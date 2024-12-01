<?php

  class FNCodeStorageModel extends Base_model
  {
    public $table = 'fn_code_storage';

    public function save_code_lib($product_id,$code_info,$oroginal_price,$discounted_price,$code_category)
	{	
			$this->db->query(
				"INSERT INTO `in_code_libraries`(`product_id`, `name`, `box_eq`, `drc_amount`, 
							 `unilevel_amount`, `binary_point`, `distribution`, `level`, `max_pair`, `status`,
							 `amount_discounted`, `amount_original`, `category`) 

				 VALUES ('$product_id','$code_info->name','$code_info->box_eq','$code_info->drc_amount',
				 		 '$code_info->unilevel_amount','$code_info->binary_point','$code_info->distribution',
				 		 '$code_info->level','$code_info->max_pair','$code_info->status','$discounted_price',
				 		 '$oroginal_price','$code_category')");
			 return $this->db->execute();
	}

	public function get_code_lib_info($id)
	{
			$this->db->query(
				"SELECT * FROM `fn_code_storage` WHERE id = '$id'"
            );
            return $this->db->single();
	}

	public function get_code_lib_all()
	{
		$this->db->query(
				"SELECT * FROM `in_code_libraries` ORDER BY `in_code_libraries`.`name` ASC"
            );
        return $this->db->resultSet();

	}

  }
