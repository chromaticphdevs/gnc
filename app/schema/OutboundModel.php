<?php

  class OutboundModel extends Model
  {
    // public $table = 'sms_outbounds';
    public $table = 'mass_sms';

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
  }
