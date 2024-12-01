<?php

  class SMS_Service extends Controller
  {

    public function index()
    {
      if(isset($_GET['api_key'] , $_GET['api_secret'] , $_GET['message'] , $_GET['number']))
      {
        $apiKey = $_GET['api_key'];
        $apiSecret = $_GET['api_secret'];
        $message = $_GET['message'];
        $number = $_GET['number'];

        //check apikey and api_secret

        $apiAccount = $this->api_account->getByAuth($apiKey , $apiSecret);

        if($apiAccount) {

          $this->sms_outbound->store([
            'api_key' => $apiAccount->key,
            'api_id'  => $apiAccount->id,
            'number'  => $number,
            'message' => $message,
            'api_level' => $apiAccount->account->level,
          ]);
        }

      }

    }
  }
