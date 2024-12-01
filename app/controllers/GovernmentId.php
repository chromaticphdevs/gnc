<?php   

    class GovernmentId extends Controller
    {

        public function __construct()
        {
            $this->model = $this->model('GovernmentIdModel');
        }
        public function index()
        {
            $res = $this->model->secondary();

            var_dump($res);
        }

        public function create()
        {
            
            return $this->view('government');
        }

        public function store()
        {
            if($this->request() === 'POST')
            {
                $type = $_POST['type'];
                $userid = Session::get('USERSESSION')['id'];
                $file = new File();
                
                $file->setFile($_FILES['idpicture'])
				->setPrefix('IMAGE')
				->setDIR(PATH_UPLOAD.DS)
                ->upload();

                $errors = $file->getErrors();
                $fileName = $file->getFileUploadName();

                if(!empty($file->getErrors())){
                    Flash::set("Upload {$type} Id failed" , 'danger');
                    return redirect("AccountProfile");
                }

                $fileName = $file->getFileUploadName();
                

                $result = $this->model->store([
                    'userid' => $userid,
                    'type'  => $type , 
                    'id_card' => $fileName
                ]);

                if($result){
                    Flash::set("$type has been uploaded");
                }

                return redirect("AccountProfile");
            }
        }
        
        public function edit()
        {

        }

        public function update()
        {
            $id  = $_POST['id'];
            $type = $_POST['type'];
            $userid = Session::get('USERSESSION')['id'];
            $file = new File();
        

            $file->setFile($_FILES['idpicture'])
				->setPrefix('IMAGE')
				->setDIR(PATH_UPLOAD.DS)
                ->upload();
                
            if(!empty($file->getErrors())){
                Flash::set("Upload {$type} Id failed" , 'danger');
                return redirect("AccountProfile");
            }


            $govid = $this->model->get($id);

            /**REMOVE OLD IMAGE */
            unlink(PATH_UPLOAD.DS.$govid->id_card);
            
            $fileName = $file->getFileUploadName();
            

            $result = $this->model->update([
                'type'  => $type , 
                'id_card' => $fileName
            ] , $id);

            if($result){
                Flash::set("$type has been updated");
            }

            return redirect("AccountProfile");
        }

        public function delete(){

        }

    }