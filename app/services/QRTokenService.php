<?php
    namespace Services;
    use Database;
    use QRcode;

    class QRTokenService {

        const RENEW_ACTION  = 'RENEW_ACTION';
        const CREATE_ACTION = 'CREATE_ACTION';
        const LOGIN_TOKEN = 'LOGIN_TOKEN';

        public static function getLatestToken($category) {
            $db = Database::getInstance();
            $db->query(
                "SELECT * FROM qr_tokens
                    WHERE category = '$category'
                    ORDER BY id desc"
            );
            return $db->single()->token ?? false;
        }

        public static function getLatest($category) {
            $db = Database::getInstance();
            $db->query(
                "SELECT * FROM qr_tokens
                    WHERE category = '$category'
                    ORDER BY id desc"
            );
            return $db->single() ?? false;
        }

        /**
         * name
         * path
         * srcURL
         * code
         */
        public static function createQRImage($params = []) {

            if(isset($params['name'])) {
                $name = $params['name'].'.png';
            } else {
                $name = get_token_random_char(12).'.png';
            }

            $abspath = $params['path'].DS.$name;
            $srcURL  = $params['srcURL'].'/'.$name;
            

            if(!file_exists($abspath)) {
                QRcode::png($params['code'], $abspath);
            }

            return [
                'path' => $abspath,
                'srcURL' => $srcURL,
                'name' => $name,
                'value' => $params['code']
            ];
        }

        public static function createWalletQR($uniqueString) {
            require_once LIBS.DS.'phpqrcode'.DS.'qrlib.php';
            $db = Database::getInstance();

            $category = "WALLET";

            $db->query(
                "SELECT * FROM qr_tokens
                    WHERE category = '$category'"
            );
            $token = [
                'recipientId' => $uniqueString,
                'date' => get_date(today(),'Y-M-d')
            ];
            
            $qrLink = URL.'/WalletController/expressSend?via=QR&token='.seal($token);
            $qrLinkEncoded = base64_encode($qrLink);

            $name = 'wallet_'.$uniqueString.'.png';
            //create new path
            $abspath = PATH_UPLOAD.DS.'wallets'.DS.$name;
            $srcURL = GET_PATH_UPLOAD.'/wallets/'.$name;

            if(!file_exists($abspath)) {
                QRcode::png($qrLink, $abspath);
            }

            $path = seal($abspath);
            $srcURL = seal($srcURL);

            return [
                'path' => $path,
                'srcURL' => $srcURL,
                'sealedLink' => seal($qrLink)
            ];
        }

        public static function renewOrCreate($category) {
            $dateNow = today();

            require_once LIBS.DS.'phpqrcode'.DS.'qrlib.php';
            $db = Database::getInstance();

            $db->query(
                "SELECT * FROM qr_tokens
                    WHERE category = '$category'"
            );
            $qrToken = $db->single();
            $token = random_number(5);
            $lastQRToken = self::getLatest($category);
            
            if ($lastQRToken->updated_at){
                $latestTokenTime = strtotime($lastQRToken->updated_at);
                $dateNowToken = strtotime($dateNow);

                $diffInSeconds = abs($latestTokenTime - $dateNowToken);
                if($diffInSeconds < 30) {
                    return;
                }
            }
            $abspath = base64_decode($lastQRToken->full_path);

            //delete old qr
            if(file_exists($abspath)) {
                unlink($abspath);
            }

            $qrLink = URL.'/QRLogin/login?token='.$token;
            $qrLinkEncoded = base64_encode($qrLink);

            $name = random_number(6).'.png';
            //create new path
            $abspath = PATH_UPLOAD.DS.$name;
            $srcURL = GET_PATH_UPLOAD.'/'.$name;
            
            QRcode::png($qrLink, $abspath);
            $path = base64_encode($abspath);
            $srcURL = base64_encode($srcURL);
            
            if (!$qrToken) {
                //create
                $db->query(
                    "INSERT INTO qr_tokens(category,token,full_path, qr_link, src_url, updated_at)
                        VALUES('{$category}','{$token}','{$path}', '{$qrLinkEncoded}', '{$srcURL}', '{$dateNow}')"
                );
                $db->execute();
            } else {
                //update
                $db->query(
                    "UPDATE qr_tokens
                        SET category = '{$category}', 
                            token = '{$token}', 
                            full_path = '{$path}',
                            qr_link = '{$qrLinkEncoded}',
                            src_url = '{$srcURL}',
                            updated_at = '{$dateNow}'
                            WHERE category = '{$category}' "
                );
                $db->execute();
            }
        }
    }