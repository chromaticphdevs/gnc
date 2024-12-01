<?php   

    class StreamComment extends Controller
    {

        public function __construct()
        {
            $this->streamCommentModel = $this->model('StreamCommentModel');
        }
        public function store()
        {
            
        }


        public function storeAjax()
        {
            if($this->request() === 'POST')
            {   
                $streamid = $_POST['streamid'];
                $comment  = $_POST['comment'];
                $userid   = Session::get('USERSESSION')['id'];

                $data = [
                    'streamid' => $streamid ,
                    'userid'   => $userid,
                    'comment'  => $comment
                ];

                $result  = $this->streamCommentModel->make_comment($data);

                if($result) {
                    echo json_encode('ok');
                }else{
                    echo json_encode('not ok');
                }
                
            }
        }

        public function allAjax()
        {
            $streamid = $_POST['streamid'];

            $result = $this->streamCommentModel->getAll($streamid);

            echo json_encode($result);
        }
    }