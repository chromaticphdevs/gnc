<?php 	

	class UserPurchaseModel extends Base_model
	{
		public function setUserId($userid)
		{
			$this->userid = $userid;
		}

		public function getBinaryTotal()
		{
			$userid = $this->userid;

			$sql = "
				SELECT sum(binary_total) as binary_total

					from orders 

					left join order_items on 
					orders.id = order_items.orderid

					where userid = '$userid'

					group by userid 
			";
		}

		public function getOrders()
		{

		}

		public function getOrderTotal()
		{
			$userid = $this->userid;

			/*this method will return binary , amount , unilvl , drc*/
			$sql = "
				SELECT sum(drc_total) as drc_total , sum(unilvl_total) as unilvl_total , 
				sum(binary_total) as binary_total , sum(price) as price_total

				from orders 
				left join order_items on
				orders.id = order_items.order_id

				where user_id = '$userid'

				group by user_id 
			";

			$this->db->query($sql);


			return $this->db->single();
		}
	}