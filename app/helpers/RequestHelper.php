<?php   
  namespace Core\Helpers;

  require_once HELPERS.DS.'StringHelper.php';
  use Core\Helpers\StringHelper;

  class RequestHelper
  {
    private static $instance = null;

    public static function getInstance()
    {
      if(self::$instance == null) {
        self::$instance = new RequestHelper();
      }

      return self::$instance;
    }

    public function __construct()
    {
      $this->request = $_REQUEST;
      $this->method  = $_SERVER['REQUEST_METHOD'];
    }

    public function method()
    {
      return $this->method;
    }


    public function isPost()
    {
      if($this->method() === 'POST')
        return true;
      return false;
    }
    public function inputs()
    {
      $getParams = $_GET ?? [];
      $postParams = $_POST ?? [];

      $fields = array_merge($_POST, $_GET);

      foreach($fields as $key => $row) {
        if(strtolower($key) === 'url'){
          continue;
        }else{
          $fields[$key] = $row;
        }
      }

      return $fields;
    }

    public function posts()
    {
      $fields = [];
      if ($this->isPost()) {
        foreach($_POST as $key => $row) {
          $fields[$key] = $row;
        }  
      }
      return $fields;
    }

    
    // public function formFields()
    // {
    //  $request = $this->request;

    //  $fields = [];

    //  foreach($request as $key => $row) {
    //    if(strtolower($key) === 'url'){
    //      continue;
    //    }else{
    //      $fields[$key] = $row;
    //    }
    //  }

    //  return $fields;
    // }
    /*return a post value*/
    public function input($name)
    {
      $method = $this->method;

      switch(strtolower($method))
      {
        case 'post':
          if(isset($_POST[$name]))
            return $_POST[$name];
        break;

        case 'get':
          if(isset($_GET[$name]))
            return $_GET[$name];
        break;
      }
    }

    public function url()
    {
      $url = $this->request['url'];

      return $url;
    }

    public function referrer()
    {
      FormSession::getInstance();
      return $_SERVER['HTTP_REFERER'] ?? '';
    }

    public function return(){
      header("Location:".$this->referrer());
    }
  }