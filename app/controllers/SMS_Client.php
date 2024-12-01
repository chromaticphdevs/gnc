<?php
  class SMS_Client extends Controller
  {
    public function __construct()
    {
      $this->sms_service = $this->model('SMS_ServiceModel');
    }

    public function index()
    {
      echo 'error';
    }

    public function doTask()
    {
      if(isset($_GET['client_id']))
      {
        $client_id = $_GET['client_id'];
        //check if client has no in progress

        if($client_id == 'D1'){
          $client = $client_id;
        }

        if($client_id == 'D2'){
          $client = $client_id;

          $tasks = $this->sms_service->getOnProgressByClient('D1');

          /*IF TASK ONE HAS NO TASK DO NOT ALLOW*/
          if(!$tasks) {
            return;
          }

        }

        $tasks = $this->sms_service->getOnProgressByClient($client);

        if($tasks) {
          //client has unfinished tasks
          return false;
        }
        /*
        *if no on progress task then assign task to client
        */
        $assignTask = $this->sms_service->assignTask($client);

        if(!$assignTask) {
        ee(api_response(['status' => true]));
        }

        ee(api_response(['status' => true]));
      }

    }

    public function updateTask()
    {
      if(isset($_GET['outbound_id'] , $_GET['sms_response']))
      {
        $this->sms_service->updateTask($_GET['outbound_id']);
      }
    }
  }
