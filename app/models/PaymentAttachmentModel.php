<?php 	

	class PaymentAttachmentModel extends Base_model
	{
		private $table_name = 'payment_attachments';
		
		public function getAttachmentByOrderId($orderid)
		{
			$sql = "SELECT * FROM $this->table_name where orderid = '$orderid'";

			$this->db->query($sql);
			return $this->db->single();
		}
	}