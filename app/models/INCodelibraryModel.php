<?php

  class INCodelibraryModel extends Base_model
  {
    public $table = 'in_code_libraries';


    public function get_one_code($code_id)
    {
    	$this->db->query("SELECT * FROM `in_code_libraries` WHERE id = {$code_id}
    		");
    	return $this->db->resultSet();
    }


    public function get($codeId)
    {
      $data = [
        $this->table,
        '*',
        " id = '{$codeId}' "
      ];
      
      return $this->dbHelper->single(...$data);
    }
  }
