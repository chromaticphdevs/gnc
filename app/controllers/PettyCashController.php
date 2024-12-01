<?php 

    class PettyCashController extends Controller
    {
        private $model;
        private $petty_user_model;
        private $auth;
        private $uploadPath;
        private $fileKey;

        private $deleteKey; //session for deleting 

        public function __construct()
        {
            parent::__construct();

            $this->model = model('PettyCashTransactionModel');
            $this->user = model('User_model');
            $this->petty_user_model = model('PettyCashUserModel');
            $this->auth = whoIs();

            $this->uploadPath = PATH_UPLOAD.DS.'petty_cash';
            $this->fileKey = 'PETTY_CASH_IMAGE';

            $this->deleteKey = get_token_random_char();
        }

        public function index() {

            if(Session::get('USERSESSION')['type'] == 1) {
                $petty_cash_per_user = $this->petty_user_model->getAll();

                $data = [
                    'petty_cash_per_user' => $petty_cash_per_user,
                    'petty_transactions'  => $this->model->getAll([
                        'order' => 'pct.id desc'
                    ])
                ];
                return $this->view('petty_cash/admin_index', $data);
                //admin
            } else {
                $current_petty_cash = $this->petty_user_model->getCurrent($this->auth['id']);
                $data = [
                    'petty_transactions' => $this->model->getAll([
                        'where' => [
                            'user_id' => $this->auth['id']
                        ],
                        'order' => 'pct.id desc'
                    ]),
                    'petty_cash_balance' => $current_petty_cash->available_balance ?? 0
                ];

                return $this->view('petty_cash/index', $data);
            }
        }

        public function create() {
            if(isSubmitted()) {
                $post = request()->posts();

                if(isset($post['username'])) {
                    //search user
                    $user = $this->user->get_by_username($post['username']);
                    if(!$user) {
                        Flash::set("User does not exists", 'danger');
                        return request()->return();
                    }
                    //change userid
                    $post['user_id'] = $user->id;
                }
                $response = $this->model->add($post);

                if($response) 
                {
                    $this->uploadImage('file',$response);
                    Flash::set("Petty Cash Entry Saved");
                    return redirect('PettyCashController');
                } else {
                    Flash::set("Something went wrong", 'danger');
                }
            }

            $data = [];
            return $this->view('petty_cash/create');
        }

        public function show($id) {
            $pettyCash = $this->model->get($id);
            if(!$pettyCash) {
                Flash::set("Petty cash does not exists");
                return redirect('PettyCashController/index');
            }
            $file = $this->_fileStorageModel->single($id, $this->fileKey);

            $data = [
                'file' => $file,
                'pettyCash'   => $pettyCash,
                'csrf'   => csrf()
            ];
            return $this->view('petty_cash/show', $data);
        }

        public function edit($id) {
            $pettyCash = $this->model->get($id);
            if(!$pettyCash) {
                Flash::set("Petty cash does not exists");
                return redirect('PettyCashController/index');
            }
            $pettyCash->amount = abs($pettyCash->amount);

            if(isSubmitted()) {
                $post = request()->posts();

                if(isset($post['change_image']))
                {   
                    $oldImage = $this->_fileStorageModel->single($post['id'], $this->fileKey);
                    $imageUpload = $this->uploadImage('file', $post['id']);

                    if(isEqual($imageUpload['status'], 'success')) {
                        if($oldImage) {
                            unset($oldImage->file_path_full);
                            $this->_fileStorageModel->dbdelete($oldImage->id);
                        }
                        Flash::set("New Image uploaded");
                        return redirect('PettyCashController/show/'.$post['id']);
                    } else {
                        Flash::set("Unable to upload your image : ". implode(',', $imageUpload['result']['err']), 'danger');
                        return request()->return();
                    }
                }

                if(isset($post['change_main']))
                {
                    $isUpdated = $this->model->update([
                        'user_id' => $pettyCash->user_id,
                        'title' => $post['title'],
                        'amount' => $post['amount'],
                        'entry_type' => $post['entry_type'],
                        'entry_date' => $post['entry_date']
                    ], $post['id']);
    
                    if(!$isUpdated) {
                        Flash::set($this->model->getErrorString(), 'danger');
                        return false;
                    }
    
                    Flash::set("Changes saved..");
                    return redirect('PettyCashController/show/'.$post['id']);
                }
            }
            $file = $this->_fileStorageModel->single($id, $this->fileKey);

            $data = [
                'file' => $file,
                'pettyCash'   => $pettyCash
            ];
            return $this->view('petty_cash/edit', $data);
        }

        public function delete($id) {
            $req = request()->inputs();
            if(!csrfValidate($req['token'])) {
                csrf();
                Flash::set("Invalid Token", 'danger');
            }
            $isDeleted = $this->model->delete($id);

            $image = $this->_fileStorageModel->single($id, $this->fileKey);

            if($image) {
                unset($image->file_path_full);
                $this->_fileStorageModel->dbdelete($image->id);
            }

            if($isDeleted) {
                Flash::set("Petty Cash Removed");
            }
            return redirect('/PettyCashController/');
        }

        private function uploadImage($fileName,$parentId) {
            //upload image
            $imageUpload = upload_image($fileName, PATH_UPLOAD.DS.'petty_cash');
            if(isEqual($imageUpload['status'], 'success')) {
                $uploadResult = $imageUpload['result'];
                $uploadId = $this->_fileStorageModel->store([
                    'parent_id' => $parentId,
                    'parent_key' => $this->fileKey,
                    'file_name' => $uploadResult['name'],
                    'file_path' => $this->uploadPath,
                    'file_extension' => $uploadResult['extension'],
                    'file_url'  => GET_PATH_UPLOAD.'/petty_cash/',
                    'display_name' => pathinfo($uploadResult['name'], PATHINFO_BASENAME)
                ]);

                $this->retVal['uploadId'] = $uploadId;
            }
            return $imageUpload;
       }
    }