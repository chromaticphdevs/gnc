<?php

    class FacebookStream extends Controller
    {

        public function __construct()
        {
            Authorization::setAccess(['admin','client']);

            $this->facebookStreamModel = $this->model('facebookStreamModel');

            $this->streamCommentModel  = $this->model('streamCommentModel');

            $this->userModel           = $this->model('User_model');

        }

        public function index()
        {
            /** SHOW LISTS OF LIVES */
            $data = [
                'title'   => 'Streams',
                'streams' => $this->facebookStreamModel->get_all()
            ];
            
            $this->view('facebooklive/stream_list' , $data);
        }

        public function show_live()
        {  
            if(isset($_GET['streamid'])) 
            {
                $stream = $this->facebookStreamModel->get_last();

                $data = [
                    'stream' =>  $stream,
                    'iframe' => self::default_iframe($stream->facebook_link),
                    'account' => $this->userModel->get_user($stream->userid),
                    'comments' => $this->streamCommentModel->getAll($stream->id)
                ];

                $this->view('facebooklive/show_stream' , $data);
            }else{
                die(" NO STREAM FOUND");
            }
            
        }

        public function edit()
        {
            if(isset($_GET['streamid']))
            {
                $streamid = $_GET['streamid'];

                $data = [
                    'stream' => $this->facebookStreamModel->get($streamid)
                ];


                $this->view('facebooklive/edit_stream' , $data);
            }

            if($this->request() === 'POST')
            {
                $result = $this->facebookStreamModel->edit($_POST);
                $stream = $this->facebookStreamModel->get($_POST['streamid']);

                if($result) {
                    Flash::set("Stream has been updated");
                }
                
                redirect("FacebookStream/show_live/?streamid={$stream->stream_code}");
            }
        }

        public function make_stream()
        {
            if($this->request() === 'POST')
            {
                $result = $this->facebookStreamModel->create_stream($_POST);

                if($result) {
                    Flash::set("Stream has been created");
                }

                redirect('FacebookStream/index');
            }else{
                $data = [
                    'title' => 'Make Live Stream Via Facebook'
                ];

                $this->view('facebooklive/make_stream' , $data);
            }
        }

        
        public static function default_iframe($src)
        {
            return base64_decode($src);
            // return '<iframe src="'.$src.'" width="1920" height="1080" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';
        }
    }