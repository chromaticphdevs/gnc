<?php 
    class API_Controller extends Controller {
        protected $bearerToken;
        /** 
         * Get header Authorization
         * */
        protected function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }

        /**
         * get access token from header
         * */
        protected function getBearerToken() {
            $headers = $this->getAuthorizationHeader();
            // HEADER: Get the access token from the header
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            return null;
        }

        protected function validateBearerToken() {
            if(!isEqual($this->bearerToken, $this->getBearerToken())) {
                return json_encode([
                    'message' => 'Invalid Bearer Token',
                    'status'  => '200',
                    'data'    => false
                ]);
            }

            return true;
        }

        protected function jsonResponse($data, $headers = []) {
            $retVal = [
                'message' => $headers['message'] ?? '',
                'statusCode' => 200,
                'warningList' => $headers['warningList'] ?? [],
                'guideList' => $headers['guideList'] ?? [],
                'data' => $data
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($retVal);
        }
    }