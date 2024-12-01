<?php

  class OutboundModel extends Base_model
  {
    // public $table = 'sms_outbounds';
    public $table = 'text_codes';

    public $status = ['sent' => 'sent' ,
    'onprogress' => 'On Progress'];

    public function store($values)
		{
			$data = [
				$this->table,
				$values
			];

			return $this->dbHelper->insert(...$data);
		}

    public function update($values , $id)
		{
			$data = [
				$this->table,
				$values,
				"id = '{$id}'"
			];

			return $this->dbHelper->update(...$data);
		}

    public function all($where , $order_by = null , $limit = null)
		{
			$data = [
				$this->table ,
				'*',
				$where,
				$order_by,
				$limit
			];
			return $this->dbHelper->resultSet(...$data);
		}

    public function getPending($param = null)
    {
      $limit  = null;
      $order  = null;

      if(isset($param['limit']))
        $limit = $param['limit'];

      if(isset($param['order']))
        $order = $param['order'];

      $data = [
        $this->table ,
        '*',
        " status = 'pending'",
        $order,
        $limit
      ];

      return $this->dbHelper->resultSet(...$data);
    }

    public function updateMultiple($fields , $ids)
    {
      $ids = implode(',' , $ids);
      $data = [
        $this->table ,
        $fields ,
        " id in ($ids)"
      ];
      return $this->dbHelper->update(...$data);
    }
  }
