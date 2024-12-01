<?php 	

	class Purchasing_model extends Base_model
	{
		public function checkout()
		{

		}
		/*
		*@param details holds the order general information cart items that have a cart_id same in the passed *param and the for_order = true will be passed to orderitems
		*/
		public function add_order($details , int $cart_id)
		{
			//will create a reandom generated string
			//this is temporary and will be changed.
			$track_no = random_gen(12);
			$user_id  = $details['user_id'];
			$address  = $details['address'];

			/*#### TEMPORARY PAYMENT METHOD ####*/
			$payment_method = 'ewallet';
			//this will be converted to stored procedure

			#insert order general details
			$this->db->query("INSERT INTO orders(track_no , payment_method ,  user_id , address) 
				VALUES(:track_no , :payment_method , :user_id ,:address)");

			$this->db->bind(':track_no' , $track_no);
			$this->db->bind(':payment_method' , $payment_method);
			$this->db->bind(':user_id' , $user_id);
			$this->db->bind(':address' , $address);

			if($this->db->execute()){

				//get order_id;
				$order_id = $this->db->lastInsertId();
				
				$sql = "INSERT INTO 
					order_items(order_id , product_id , price , binary_total , 
					unilvl_total , drc_total ,quantity , total)";

				$sql .= " SELECT '$order_id' , ci.product_id , 
				p.price , 
				(ci.quantity * p.binary_pb_amount) , 
				(ci.quantity * p.unilvl_amount) , 
				(ci.quantity * p.drc_amount) ,
				(ci.quantity) , 
				(ci.quantity * p.price)  ";

				$sql .= " 
				FROM cart_items as ci

				left join products as p 
				on p.id = ci.product_id 

				where ci.cart_id = '$cart_id'";
				$this->db->query($sql);

				if($this->db->execute())
					return $order_id;
				return FALSE;
			}
			return FALSE;
		}
	}