<?php

use Zxing\Qrcode\Decoder\Mode;

    class API_ImageUploaderController extends Controller
    {
        public function uploadImage() {
            $post = request()->posts();

            if(!empty($post['image'])) {
                $imageArray = explode(';', $post['image']); //extract unwated data from base64 image
                $imageArrayEncoded = explode(',', $imageArray[1]);

                switch($post['sourceFor']) {
                    case 'profilePicture': 
                        $imageResponse = $this->saveImage($imageArrayEncoded[1], PATH_UPLOAD.DS.'profile');
                        if(!isset($this->accountModel)) {
                            $this->accountModel = model('AccountModel');
                        }
                        $isUpdated = $this->accountModel->update_profile($post['userId'], $imageResponse['imageName']);

                        echo api_response([
                            'imageResponse' => $imageResponse,
                            'isUpdated' => $isUpdated
                        ]);
                        return;
                    break;

                    case 'validId':
                        $imageResponse = $this->saveImage($imageArrayEncoded[1], PUBLIC_ROOT.DS.'assets/user_id_uploads');
                        if(!isset($this->userIdVerificationModel)) {
                            $this->userIdVerificationModel = model('UserIdVerificationModel');
                        }
                        $repsonse = $this->userIdVerificationModel->saveId($post['userId'], $post['idType'], $post['facing'], $imageResponse['imageName']);
                        echo api_response([
                            'imageResponse' => $imageResponse,
                            'hey' => 'its from valid id',
                        ], $repsonse);

                        return;
                    break;

                    case 'esig':
                        $imageResponse = $this->saveImage($imageArrayEncoded[1], PUBLIC_ROOT.DS.'assets/signatures');
                        $userModel = model('user_model');

                        $userModel->dbupdate([
                            'esig' => $imageResponse['imageName']
                        ], $post['userId']);

                        echo api_response([
                            $post
                        ], true);
                        return;
                    break;


                    case 'loan_release_image':
                        $cashAdvanceReleaseModel = model('CashAdvanceReleaseModel');

                        $cashAdvanceRelease = $cashAdvanceReleaseModel->get([
                            'where' => [
                                'cdr.id' => $post['sourceId']
                            ]
                        ]);

                        if($cashAdvanceRelease) {
                            $imageResponse = $this->saveImage($imageArrayEncoded[1], PUBLIC_ROOT.DS.'assets/loan_release_images', [
                                'name' => $cashAdvanceRelease->release_reference
                            ]);
    
                            $isUpdated = $cashAdvanceReleaseModel->dbupdate([
                                'image_proof' => $imageResponse['imageName']
                            ], $post['sourceId']);

                            echo api_response([
                                'imageResponse' => $imageResponse,
                                'isUpdated' => $isUpdated
                            ]);
                            return;
                        }
                    break;

                    case 'cash_advance_payment_proof':
                        $cashAdvancePaymentModel = model('CashAdvancePaymentModel');

                        $cashAdvancePayment = $cashAdvancePaymentModel->get([
                            'where' => [
                                'payment.id' => $post['sourceId']
                            ]
                        ]);

                        if($cashAdvancePayment) {
                            $imageResponse = $this->saveImage($imageArrayEncoded[1], PUBLIC_ROOT.DS.'assets/cash_advance_payments', [
                                'name' => $cashAdvancePayment->payment_reference
                            ]);
    
                            $isUpdated = $cashAdvancePaymentModel->dbupdate([
                                'image_proof' => $imageResponse['imageName']
                            ], $post['sourceId']);

                            echo api_response([
                                'imageResponse' => $imageResponse,
                                'isUpdated' => true
                            ]);
                            return;
                        }
                        return;
                    break;
                }
                //save to attachments
            }
            echo json_encode($_POST);
            return;
        }

        public function addGroupChatImage() {
            $this->chatModel = model('ChatModel');

            if(isSubmitted()) {
                $post = request()->posts();

                if(!empty($post['image'])) {
                    $imageArray = explode(';', $post['image']); //extract unwated data from base64 image
                    $imageArrayEncoded = explode(',', $imageArray[1]);
                    $imageResponse = $this->saveImage($imageArrayEncoded[1], PUBLIC_ROOT.DS.'assets/chat_assets');
                    $messageId = $this->chatModel->addNewGroupMessage($post['gcId'], $post['userId'], $post['attachmentChat'], $imageResponse['imageName'], true);

                    echo api_response([
                        'imageResponse' => $imageResponse,
                        'isUpdated' => $messageId
                    ]);
                    return;
                }
            }
        }

        /**
         * options = name,
         */
        private function saveImage($imageBase64EncodedData, $path, $options = []) {
            $data = base64_decode($imageBase64EncodedData);
            $imageName = $options['name'] ?? time();
            $imageName = $imageName .= '.png';
            $fullPath = $path . DS . $imageName;
            file_put_contents($fullPath, $data);

            return [
                'imageName' => $imageName,
                'fullPath'  => $fullPath,
                'path'      => $path,
                'url'       => $options['url'] ?? '',
                'ext'       => 'png'
            ];
        }
    }