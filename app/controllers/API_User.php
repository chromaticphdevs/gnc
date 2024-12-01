<?php

  class API_User extends Controller
  {

    public function __construct()
    {
      $this->user = $this->model('User_model');
    }

    public function getByUserName()
    {
      $username = $_GET['username'];

      $data = $this->user->get_user_by_username($username);
      
      echo ee(api_response($data));
    }

    public function getByKeyword()
    {
      $keyword = $_GET['key_word'];
      $limit   = $_GET['limit'] ?? 100000;

      $res = $this->user->getByKeyPair(['username' => $keyword] , 'username asc' , $limit);

      dd($res);
    }


    public function index()
    {
      $userid = 9;
      $purchasedLevel = 'bronze';
      
      $accountMaker = new AccountMakerObj($userid , $purchasedLevel);
      
      $accountMaker->run();

    }


    public function updateMobile()
    {
      $post = request()->inputs();


      $mobileExists = $this->user->getByMobile($post['mobileNumber']);

      if($mobileExists)
      {
        ee(api_response('Mobile number already ownerd' , false));
      }else
      {
        $response = $this->user->dbupdate([
          'mobile' => $post['mobileNumber']
        ], $post['userId']);

        if($response) {
          ee(api_response('Mobile Number updated'));
        }else{ 
          ee(api_response('Something went wrong' , false));
        }
      }
      
    }
  }
