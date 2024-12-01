<?php 
    
    class UserOwnedQRController extends Controller
    {
        public function __construct()
        {
            $this->qr_code_model = model('UserOwnedQRModel');
            if(!whoIs())
                return redirect('users/login');
        }
        public function index()
        {
            $whoIs = whoIs();

            $qr_codes = $this->qr_code_model->getAll([
                'where' => [
                    'user_id' => $whoIs['id'],
                    'uoq.is_used' => false
                ],
                'order' => 'uoq.is_used asc, uoq.id desc'
            ]);

            $data = [
                'qr_codes' => $qr_codes,
                'user_id' => $whoIs['id']
            ];

            return $this->view('user_owned_qr/index' , $data);
        }
        public function sendTo($qr_id)
        {
            if(isEqual($this->request(), 'POST')) {
                $post = request()->inputs();

                $res = $this->qr_code_model->sendTo($post);

                if(!$res) {
                    Flash::set( $this->qr_code_model->getErrorString() , 'danger');
                    return request()->return();
                }

                Flash::set("QR Code sent to user");
                return redirect('UserOwnedQRController/index');
            }

            $code = $this->qr_code_model->get( $qr_id );

            if( !$this->qr_code_model->isOwnedByUser( whoIs()['id'] , $code->user_id ) )
            {
                Flash::set("Invalid Request");
                return redirect('UserOwnedQRController/index');
            }
            $data = [
                'title' => 'Send QR Code Do',
                'code'  => $code
            ];

            return $this->view('user_owned_qr/send_to' , $data);
        }

        public function sendMultiple() {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                $res = $this->qr_code_model->sendToMultiple($post);

                if(!$res) {
                    Flash::set($this->qr_code_model->getErrorString(), 'danger');
                } else {
                    Flash::set("Qr Sent");
                }

                return redirect('UserOwnedQRController/index');
            }

            if(!empty($req['ids'])) {
                $qr_code_ids = explode(',', $req['ids']);

                $data = [
                    'qr_codes' => seal($qr_code_ids)
                ];
                return $this->view('user_owned_qr/send_to_multiple' , $data);
            }
        }

        
        public function useToSelf()
        {
            
        }
        /**
         * use code to self
         * and gain point
         */
        public function topUp()
        {
            if(request()->isPost()) {
                $post = request()->inputs();
                $res = $this->qr_code_model->topUp($post['qr_id']);
                if(!$res) {
                    Flash::set($this->qr_code_model->getErrorString(),'danger');
                }else{
                    if (!empty($this->qr_code_model->getMessages())) {
                        Flash::set($this->qr_code_model->getMessageString());
                    } else {
                        Flash::set("Top Up applied");
                    }
                }
                return request()->return();
            }
        }

        public function update_position()
        {
            $result = $this->qr_code_model->dbupdate([
                'downline_position' => $_POST['position']
            ] , $_POST['user_qr_id']);

            echo json_encode([
                $result,
                $_POST
            ]);
        }
    }