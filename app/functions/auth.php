<?php   
  

  function authCookie()
  {
    $cookie = Cookie::get('USERSESSION');

    if(!$cookie)
      return false;
    return $cookie;
  }

  function authPanelCookie()
  {
    $cookie = authCookie();

    if(!$cookie)
      return false;
    
    $name = $cookie->username;

    if(empty($name))
      $name = $cookie->firstname;


    $whoIs = whoIs();

    if($cookie && is_null($whoIs)) {
      
        echo'<div class="alert alert-warning text-center">
          <a href="/CookieAuth/relogin" style="color: #000">
            <h5 class="text-underline" style="text-decoration: underline;">
              Login as '.$name.'
            </h5>
          </a>
          <small>Last user logged in</small>
        </div>';
      
    }
  }

  function is_logged_in()
  {
    if(Session::check('is_logged_in'))
      return true;

    return false;
  }

  function set_logged_in()
  {
    Session::set('is_logged_in' , TRUE);
  }



  function get_user_position()
  {

    $position = 2;

    if(is_logged_in())
    {

      $user_position = Session::get('USERSESSION')['type'];


      switch ($user_position) {
        case '1':
          $position = 'admin';
          break;
        
        default:
          $position = 'user';
          break;
      }
    }

    echo $position;
  }

  function get_user_id()
  {

    if(is_logged_in())
    {
      echo Session::get('USERSESSION')['id'];
    }
  }

  function get_user_username()
  {
    $username = '';
    if(Session::check('USERSESSION')) {
      $username = Session::get('USERSESSION')['username'];
    }

    if(Session::check('BRANCH_MANAGERS')){
      $username = Session::get('BRANCH_MANAGERS')->username;
    }
    echo $username;
  }

  function get_user_status()
  {
    $status = '';
    if(Session::check('USERSESSION')) {
      $status = Session::get('USERSESSION')['status'];
    }

    if(Session::check('BRANCH_MANAGERS')){
      $status = Session::get('BRANCH_MANAGERS')->type;
    }
    echo $status;
  }


  function hasLoggedIn($name = 'USERSESSION')
  {
    if(Session::check($name))
      return true;
    return false;
  }

  function check_session()
  {

    if(Session::check('BRANCH_MANAGERS'))
    {
      $user = Session::get('BRANCH_MANAGERS');
      $branchid = $user->branchid;
      return $branchid;

    }else if(Session::check('USERSESSION'))
    {
      $branchid = 8;
      return $branchid;

    }else{
      redirect('user/login');
    }
  }

   function get_userid()
  {
    if(Session::check('BRANCH_MANAGERS'))
    {
      $user = Session::get('BRANCH_MANAGERS');
      $userid = $user->id;
      return $userid;

    }else if(Session::check('USERSESSION'))
    {
      $user = Session::get('USERSESSION');
      $userid = $user['id'];
      return $userid;

    }else{
      redirect('user/login');
    }
  
  }