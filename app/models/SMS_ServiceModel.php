<?php

  class SMS_ServiceModel extends Base_model
  {
    public $maxTask = 3;

    public function __construct()
    {
      parent::__construct();
      $this->outbound = new OutboundModel();
    }

    public function getOnProgressByClient($client_id)
    {
      return $this->outbound->all(
        "status = 'on progress' and client_id = '{$client_id}'"
      );
    }

    public function assignTask($client_id)
    {
      $param = [
        'limit' => $this->maxTask,
        'order' => 'id asc'
      ];
      //prioritize premium
      $pendingOutbounds = $this->outbound->getPending($param);

      if(!$pendingOutbounds)
        return;//no result

      $updateParam =
      [
        [
          'client_id' => $client_id,
          'status'    => 'on progress',
        ],
        $this->extractOutboundIds($pendingOutbounds)
      ];

      return $this->outbound->updateMultiple(...$updateParam);
    }

    public function updateTask($sms_id)
    {
      $param = [
        [
          'status' => 'sent'
        ] ,
        $sms_id
      ];

      return $this->outbound->update(...$param);
    }

    public function extractOutboundIds($pendingOutbounds)
    {
      $returnData = [];

      foreach($pendingOutbounds as $key => $row) {
        array_push($returnData , $row->id);
      }

      return $returnData;
    }
  }
