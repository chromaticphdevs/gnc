<?php

  abstract class Controller{
    //gump is a validator
    protected $gump;
    protected $_fileStorageModel;

    public $navigationHelper;
    public function __construct()
    {
      $this->gump = new Gump();
      $this->_fileStorageModel = model('FileStorageModel');
      $this->data = [
        '_whoIs' => whoIs()
      ];

      $this->navigationHelper = new NavigationHelper();
      $response = $this->navigationHelper->getNavsHTML();
    }

    public function model($model)
    {

      $model  = ucfirst($model);

      if(file_exists(MODELS.DS.$model.'.php')){

        require_once MODELS.DS.$model.'.php';

        return new $model;
      }
      else{

        die($model . 'MODEL NOT FOUND');
      }
    }


    public function view($view , $data = [])
    {
      extract($data);

      if(file_exists(VIEWS.DS.$view.'.php'))
      {
          require_once VIEWS.DS.$view.'.php';
      }else{
          die("View does not exists {$view}");
      }
    }

    protected function request()
    {
      if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST'){

        return 'POST';
      }
      else{
        return 'GET';
      }
    }

    final protected function load_model($model_name , $model_instance)
    {
      $this->$model_instance = $this->model($model_name);
    }
  }
