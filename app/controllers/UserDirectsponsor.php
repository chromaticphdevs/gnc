<?php

    class UserDirectsponsor extends Controller
    {
      public function __construct()
      {
        parent::__construct();
        $this->geneology = $this->model('geneology_model');
        $this->linkShortenerModel = model('LinkShortenerModel');
        $this->userModel = model('User_model');
        $this->sponsorVideoModel = model('SponsorVideoModel');
        $this->userSocialMedia = model('UserSocialMediaModel');
        $this->preRegisterModel = model('PreRegisterModel');
      }

      public function index()
      {

        if(!whoIs()) {
          Flash::set("Unauthorize access" , 'danger');
          return redirect("users/login");
        }

        $user_id = whoIs()['id'];

        $linkLeft = seal(['user_id' => $user_id, 'position' => 'LEFT', 'upline' => $user_id]);
        $linkRight = seal(['user_id' => $user_id, 'position' => 'RIGHT', 'upline' => $user_id]);
        $leftLinkRedirectTo = URL.DS."/UserController/referralLink?q={$linkLeft}";

        $shortenedLink = $this->linkShortenerModel->add($leftLinkRedirectTo, whoIs('username'), whoIs('id'));
        $shortenedLink = $this->linkShortenerModel->getShortenedLink($shortenedLink->shortened_key);
        
        $mergedUsers = [];

        $directs = $this->userModel->getAll([
          'where' => [
            'user.direct_sponsor' => $user_id
          ]
        ]);

        $preRegisteredUsers = $this->preRegisterModel->dbget_desc('id', $this->preRegisterModel->convertWhere([
          'created_by' => $user_id
        ]));

        //append social media data
        foreach($directs as $key => &$row) {
          $socialmedia = $this->userSocialMedia->get_fb_link($row->id);
          $row->fb = $socialmedia;
        }

        foreach($directs as $key => &$row) {
          $mergedUsers[] = (object) [
            'id' => $row->id,
            'firstname' => $row->firstname,
            'lastname' => $row->lastname,
            'fullname' => $row->firstname . ' ' . $row->lastname,
            'mobile' => $row->mobile,
            'created_at' => $row->created_at,
            'fb_link' => $row->fb->link ?? '',
            'sp_id' => $row->sp_id,
            'sp_video_file' => $row->sp_video_file,
            'registration_status' => 'registered',
            'is_user_verified' => $row->is_user_verified
          ];
        }

        foreach($preRegisteredUsers as $key => $row) {
          $mergedUsers[] = (object) [
            'id' => $row->id,
            'firstname' => $row->firstname,
            'lastname' => $row->lastname,
            'fullname' => $row->firstname . ' ' .  $row->lastname ,
            'mobile' => $row->phone,
            'created_at' => $row->created_at,
            'fb_link' => '',
            'sp_id' => '',
            'sp_video_file' => '',
            'registration_status' => 'pending',
            'is_user_verified'  => false
          ];
        }

        $data = [
          'directs' => $directs,
          'links' => [
            'left' => URL.DS."/UserController/referralLink?q={$linkLeft}",
            'right' => URL.DS."/UserController/referralLink?q={$linkRight}",
            'shortenedLink' => $shortenedLink
          ],
          'mergedUsers' => $mergedUsers,
          'navigationHelper' => $this->navigationHelper
        ];
        
        return $this->view('geneology/unilevel_table'  , $data);
      }

      public function activated_users()
      {
        if(!isset($_SESSION['USERSESSION'])){
          Flash::set("Unauthorize access" , 'danger');
          return redirect("users/login");
        }

        $user_id = Session::get('USERSESSION')['id'];

        $data = [
          'directs' => $this->geneology->getUnilevelWithSocialMediaAccountAndActivated($user_id , 'facebook')
        ];

   
        return $this->view('geneology/unilevel_table'  , $data);
      }

      public function users_status_search($status)
      {
        if(!isset($_SESSION['USERSESSION'])){
          Flash::set("Unauthorize access" , 'danger');
          return redirect("users/login");
        }

        $user_id = Session::get('USERSESSION')['id'];

        $data = [
          'directs' => $this->geneology->getUnilevelWithSocialMediaAccountAndPreActivated($user_id , 'facebook', $status)
        ];

   
        return $this->view('geneology/unilevel_table'  , $data);
      }

      /**
       * upload video for each users
       */
      public function uploadVideo($beneficaryId) {
        authRequired();
        $req = request()->inputs();
        
        if(isSubmitted()) {
          $post = request()->posts();
          $upload = upload_file('file', BASE_DIR.DS.'public/assets/user_videos');
          
          if(isEqual($upload['status'], 'success')) {
            $uploadId = $this->sponsorVideoModel->add(whoIs('id'), unseal($beneficaryId), $upload['result']['name']);
            if($uploadId) {
              Flash::set("Video Uploaded");
              return redirect('UserDirectsponsor/viewVideo/' . seal($uploadId));
            }
          } else {
              Flash::set("Something went wrong", 'danger');
              return request()->return();
          }
        }


        $beneficaryId = unseal($beneficaryId);
        $member = $this->userModel->get_user($beneficaryId);

        $data = [
          'member' => $member,
          'navigationHelper' => $this->navigationHelper
        ];
        return $this->view('user_directsponsor/upload_video', $data);
      }

      public function viewVideo($videoId) {
        authRequired();
        $data = [
          'video' => $this->sponsorVideoModel->dbget(unseal($videoId)),
          'navigationHelper' => $this->navigationHelper
        ];
        return $this->view('user_directsponsor/view_video', $data);
      }

      public function deleteVideo($videoId) {
        authRequired();
        $videoId = unseal($videoId);
        // PATH_PUBLIC.DS.'assets/user_videos/'.$video->video_file
        $video = $this->sponsorVideoModel->dbget($videoId);

        if($video) {
          $this->sponsorVideoModel->dbdelete($videoId);
          unlink(BASE_DIR.DS.'public/assets/user_videos/' . $video->video_file);
          return redirect('UserDirectsponsor/index');
        }
      }
    }
