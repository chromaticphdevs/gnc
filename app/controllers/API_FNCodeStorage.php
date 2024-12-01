<?php

  class API_FNCodeStorage extends Controller
  {
    public function __construct()
    {
      $this->codestorage = $this->model('FNCodeStorageModel');
    }

    public function get()
    {
      if(isset($_POST['code_id'])){

        $code_id = $_POST['code_id'];
        
        $data = $this->codestorage->dbget($code_id);
        ee(api_response($data));
      }
    }
  }
