<?php 	

	class Order_model extends Base_model
	{

		private $table_name = 'orders';

		public function __construct()
		{
			parent::__construct();
		}


		public function getList($params = null)
		{
			/**SELECT ORDER INFO**/
			$sql = "
			SELECT o.* , concat(firstname , ' ' , lastname) as customer FROM $this->table_name as o

			left join users as u
			on u.id = o.user_id
			$params";

			$this->db->query($sql);

			return $this->db->resultSet();
		}

		public function getOrder($orderid)
		{
			return [
				'orderDetails' => $this->getOrderDetails($orderid),
				'orderItems'  => $this->getOrderItems($orderid)
			];
		}
		
		public function getOrderDetails($orderid)
		{
			$this->db->query("
			SELECT o.* , concat(firstname , ' ' , lastname) as customer FROM $this->table_name as o

			left join users as u
			on u.id = o.user_id where o.id = '$orderid'");

			return $this->db->single();
		}

		private function getOrderItems($orderid)
		{
			$this->db->query(
				"SELECT oi.* , name , image , (oi.price * oi.quantity) as total 
				FROM order_items as oi 

				left join products as p 
				on oi.product_id = p.id

				where oi.order_id = '$orderid'"
			);

			return $this->db->resultSet();
		}

		public function get_all_orders($params =  null)
		{
			$this->db->query(
				"SELECT o.* ,o.id as order_id, CONCAT(u.firstname , ' ' , u.lastname) as fullname , sum(oi.total) as total FROM orders as o 
					left join order_items as oi 
					on oi.order_id = o.id 

					left join users as u 
					on u.id = o.user_id
					
					$params
					group by o.id

					"
			);

			return $this->db->resultSet();
		}


		public function get_user_order_list(int $user_id)
		{

			$this->db->query(
				"SELECT o.*, time(o.dt) as time , o.id as order_id, CONCAT(u.firstname , ' ' , u.lastname) as fullname , sum(oi.total) as total FROM orders as o 
					left join order_items as oi 
					on oi.order_id = o.id 

					left join users as u 
					on u.id = o.user_id

					where o.user_id = :user_id
					
					group by o.id 
				"
			);

			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}
		public function get_order_by_id(int $order_id)
		{
			//params
			$data = [
				'order_details' => '' , 
				'order_items'   => ''
			];
			//order_details
			$this->db->query(
				"SELECT o.id as order_id , o.o_status as o_status , o.track_no as o_track_no , o.payment_method as o_payment_method ,concat( u.firstname , ' ' , u.lastname) as fullname FROM orders as o 
				left join users as u 
				on u.id = o.user_id 
				where o.id = :order_id"
			);
			$this->db->bind(':order_id' , $order_id);

			$data['order_details'] = $this->db->single();

			//order items

			$this->db->query("
					SELECT oi.price as oi_price ,  oi.quantity as oi_quantity , oi.total as oi_total ,
					p.name as p_name ,p.price as p_price FROM order_items as oi 

					left join products as p
					on oi.product_id = p.id 

					where order_id = :order_id
				");
			$this->db->bind(':order_id' , $order_id);

			$data['order_items'] = $this->db->resultSet();

			return $data;
		}

		public function accept_order(int $order_id)
		{
			$this->db->query("UPDATE orders set o_status = 'accepted' where id = :order_id");

			$this->db->bind(':order_id' , $order_id);

			if($this->db->execute())
				return TRUE;
			return FALSE;
		}

		/*
		*FOR COMMISSION PURPOSES
		*
		*/
		private function get_order_items(int $order_id)
		{
			$order_loop = 10;

			$this->db->query("
				SELECT user_id , sum(drc_amount * oi.quantity)  as drc_amount , sum(unilvl_amount * oi.quantity) as unilvl_amount , 
				sum(binary_pb_amount * oi.quantity) as binary_pb_amount , 
				'$order_loop' as distribution

				FROM order_items as oi 

				left join products as p 
				on oi.product_id = p.id

				left join orders as o 
				on oi.order_id = o.id

				where order_id = :order_id

				group by oi.order_id

				");

			$this->db->bind(':order_id' , $order_id);

			return $this->db->single();
		}

		public function get_order_item(int $order_id)
		{
			$order_loop = 10;

			$this->db->query(
				"SELECT user_id , order_id , oi.price,
				sum(drc_amount * oi.quantity)  as drc_amount , 
				sum(unilvl_amount * oi.quantity) as unilvl_amount , 
				sum(binary_pb_amount * oi.quantity) as binary_pb_amount , 
				p.max_pair as max_pair,
				com_distribution as distribution 

				FROM order_items as oi 

				left join products as p 
				on oi.product_id = p.id

				left join orders as o 
				on oi.order_id = o.id

				where order_id = :order_id

				group by oi.order_id , p.id

				limit 1"
			);

			$this->db->bind(':order_id' , $order_id);

			return $this->db->single();
		}

		public function get_activation_order($userid) 
		{	
			$this->db->query(
				"SELECT * FROM orders where o_status = 'accepted' and user_id = '$userid'"
			);

			return $this->db->single();
		}
	}