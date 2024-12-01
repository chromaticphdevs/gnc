<?php 

    class LoanProcessorVideoController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->userModel = model('User_model');
            $this->loanProcessorVideoModel = model('LoanProcessorVideoModel');
        }
        public function index($userId = null) {

            if(is_null($userId)) {
                $userId = whoIs('id');
            } else {
                $userId = unseal($userId);
            }
            $data = [
                'userid' => $userId,
                'processedLoans' => $this->loanProcessorVideoModel->getAll([
                    'where' => [
                        'user.loan_processor_id' => $userId
                    ]
                ])
            ];
            return $this->view('loan_processor_video/index', $data);
        }

        public function create($beneficaryId) {
            $beneficaryId = unseal($beneficaryId);

            if(isSubmitted()) {
                $post = request()->posts();
                $upload = upload_file('file', BASE_DIR.DS.'public/assets/user_videos');
                
                if(isEqual($upload['status'], 'success')) {
                    $uploadId = $this->loanProcessorVideoModel->add(whoIs('id'), $beneficaryId, $upload['result']['name']);
                    if($uploadId) {
                        Flash::set("Video Uploaded");
                        return redirect('LoanProcessorVideoController/show/' . seal($uploadId));
                    }
                } else {
                    Flash::set("Something went wrong", 'danger');
                    return request()->return();
                }
            }


            $member = $this->userModel->get_user($beneficaryId);

            $data = [
                'navigationHelper' => $this->navigationHelper,
                'member' => $member
            ];
            return $this->view('loan_processor_video/create', $data);
        }

        public function show($userId) {
            authRequired();
            $data = [
                'video' => $this->loanProcessorVideoModel->dbget(unseal($userId)),
                'navigationHelper' => $this->navigationHelper
            ];
            return $this->view('loan_processor_video/show', $data);
        }

        public function deleteVideo($videoId) {
            authRequired();
            $videoId = unseal($videoId);
            // PATH_PUBLIC.DS.'assets/user_videos/'.$video->video_file
            $video = $this->loanProcessorVideoModel->dbget($videoId);
    
            if($video) {
              $this->loanProcessorVideoModel->dbdelete($videoId);
              unlink(BASE_DIR.DS.'public/assets/user_videos/' . $video->video_file);
              return redirect('LoanProcessorVideoController/index');
            }
          }
    }