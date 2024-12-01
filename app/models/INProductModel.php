<?php   

    class INProductModel extends Base_model 
    {
        public $table = 'in_products';

        public function get_list_asc($field , $where = null)
		{
			$data = [
				$this->table,
				'*',
				null,
				" $field asc "
			];

			return
				$this->dbHelper->resultSet(...$data);
		}
    }