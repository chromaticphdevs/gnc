<?php

	class Store_product_model extends Base_model
	{
		public function getList($params = null)
		{
			$this->db->query(
				"SELECT p.id as prodid , p.name as p_name , p.price as p_price , p.package_quantity as 
				p_quantity , p.drc_amount as drc_amount , p.image as p_image,
				p.unilvl_amount as unilvl_amount ,
				p.binary_pb_amount as bp_amount ,
				p.description as p_desc , p.com_distribution as distribution,
				max_pair

				from products as p 
				$params"
			);


			return $this->db->resultSet();
		}

		public function get_product($product_id)
		{
			$this->db->query(
				"SELECT p.id as prodid , store_id , p.name as p_name , p.price as p_price , p.image as p_image, p.package_quantity as 
				p_quantity , p.drc_amount as drc_amount ,
				p.unilvl_amount as unilvl_amount ,
				p.binary_pb_amount as bp_amount ,
				p.description as p_desc , p.com_distribution as distribution ,
				p.verification as verification , p.product_from as product_from,
				max_pair

				from products as p 

				where p.id = '$product_id'"
			);

			return $this->db->single();
		}

		public function create($product ,  $image)
		{
			extract($product);
			
			foreach($product as $key=>$value)
			{
				$product[$key] = StringMethod::_clean($value);
			}

			$description = filter_var($description , FILTER_SANITIZE_STRING);
			/*Check if the auth is admin*/
			if($this->checkAuth() === '1')
			{
				$store_id = 1;

				$this->db->query(
					"INSERT INTO products(store_id , name , image , price ,
					package_quantity , drc_amount , unilvl_amount , binary_pb_amount ,
					is_visible , description , com_distribution, verification , product_from, max_pair)


					VALUES('$store_id' , '$name' , '$image' , '$price' , '$quantity' ,
					'$drc_amount' , '$unilvl_amount' , '$bp_points' , '1' , 
					'$description' , '$com_distribution' , 'verified' , 'admin' , '$max_pair')"
				);

			}else{
				/*GET CUSTOMERS ID*/
				$store_id = Session::get('USERSESSION')['id'];

				$this->db->query(
					"INSERT INTO products(store_id , name , image , price ,
					package_quantity , drc_amount , unilvl_amount , binary_pb_amount ,
					is_visible , description , com_distribution, verification , product_from, max_pair)


					VALUES('$store_id' , '$name' , '$image' , '$price' , '$quantity' ,
					'$drc_amount' , '$unilvl_amount' , '$bp_points' , '1' , 
					'$description' , '$com_distribution' , 'unverified' , 'user' , '$max_pair')"
				);
			}

			if($this->db->execute())
				return TRUE;
			return FALSE;
		}

		public function update_product($productInfo)
		{
			extract($productInfo);

			$this->db->query(
				"UPDATE products set name = '$name' , price = '$price' , 
				package_quantity = '$quantity' , drc_amount = '$drc_amount' , 
				unilvl_amount = '$unilvl_amount', binary_pb_amount = '$bp_points' ,
				max_pair = '$max_pair' where id = '$prodid'"
			);

			try{
				$this->db->execute();

				Flash::set("Product information has been updated");
				redirect('storeProduct/edit/'.$prodid);
			}catch(Exception $e) {
				Flash::set($e->getMessage() , 'danger');
			}
		}
		/*this will check if the auth is admin or na*/
		private function checkAuth()
		{
			$auth = Session::get('USERSESSION');

			return $auth['type'];
		}


		public function verify($prodid)
		{
			$this->db->query("UPDATE products set verification = 'verified' where id = '$prodid'");

			return $this->db->execute();
		}

		public function unverify($prodid)
		{
			$this->db->query("UPDATE products set verification = 'unverified' where id = '$prodid'");

			return $this->db->execute();
		}
	}