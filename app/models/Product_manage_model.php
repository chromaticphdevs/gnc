<?php

	class Product_manage_model extends Base_model
	{
		private $table_name = 'products';

		public function updateAll($product)
		{
			extract($product);

			foreach($product as $key=>$value)
			{
				$product[$key] = StringMethod::_clean($value);
			}
			
			$this->db->query(
				"UPDATE $this->table_name set name = '$name' ,price = '$price' ,
				package_quantity = '$quantity' , 
				drc_amount = '$drc_amount' , unilvl_amount = '$unilvl_amount',
				binary_pb_amount = '$bp_points' , 
				description = '$description' ,
				com_distribution = '$com_distribution'

				where id = '$prodid'"
			);

			if($this->db->execute())
				return TRUE;
			return FALSE;
		}

		public function updateImage($product , $image)
		{
			extract($product);
			
			$this->db->query("UPDATE $this->table_name set image = '$image' where id = '$productID'");

			if($this->db->execute())
				return TRUE;
			return FALSE;
		}
		public function updateName($product)
		{
			extract($product);

			return $this->updateField('name' , $productID , $value);
		}
		public function updatePrice($product)
		{
			extract($product);

			return $this->updateField('price' , $productID , $value);
		}

		public function updateQuantity($product)
		{
			extract($product);

			return $this->updateField('package_quantity' , $productID , $value);
		}

		public function updateDRC($product)
		{
			extract($product);

			return $this->updateField('drc_amount' , $productID , $value);
		}

		public function updateUNILVL($product)
		{
			extract($product);

			return $this->updateField('unilvl_amount' , $productID , $value);
		}

		public function updateBP_AMOUNT($product)
		{
			extract($product);

			return $this->updateField('binary_pb_amount' , $productID , $value);
		}

		public function update_maxpair($product) 
		{
			extract($product);

			return $this->updateField('max_pair' , $productID , $value);
		}

		private function updateField($field , $id , $value)
		{
			$this->db->query("UPDATE $this->table_name set $field = '$value' where id = '$id'");

			if($this->db->execute())
				return true;
			return false;
		}
		public function duplicate($product)
		{
			extract($product);

			$user = Session::get('USERSESSION');

			$verification = 0;

			if($user['type'] == 1){
				$verification = 1;
			}	

			$this->db->query(
				"INSERT INTO products(name , store_id , image , price , package_quantity , drc_amount , unilvl_amount , binary_pb_amount , is_visible , description , com_distribution , verification)
				SELECT name , store_id , image , price , package_quantity , drc_amount , unilvl_amount , binary_pb_amount , is_visible , description , com_distribution , '$verification' 
				from products where id = '$productID'"
			);
			if($this->db->execute())
				return true;
			return false;
		}
	}