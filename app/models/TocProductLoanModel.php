<?php 	

	class TocProductLoanModel extends Base_model
	{

		public function __construct()
		{
			parent::__construct();

			$this->fnproductReleaseModel = model('FNProductReleaseModel');

			$this->productDeliveryModel = model('ProductDeliveryModel');

			$this->deliveryModel = model('FNDeliveryInfoModel');
		}

		public function loan($loanData)
		{				//returns loanId
			$autoloan = mAutoloan([
				'codeId' => $loanData['codeId'],
				'amount' => $loanData['amount'],
				'quantity' => $loanData['quantity'],
				'delivery_fee' => $loanData['delivery_fee'],
				'shipping_details' => $loanData['shipping_details'],
				'user_id' => $loanData['user_id']
			]);

			$this->autoloan = $autoloan;
			$this->reference = $autoloan['loanReference'];

			$user = $autoloan['models']['user']->get_user($loanData['user_id']);
			$code = $autoloan['code'];

			$box = 'box';
			if($code->box_eq > 1)
				$box = 'boxes';

			$productName = $code->name . ' ' .'('.$code->box_eq.')'.$box;


			$this->save_shiping_number($loanData['user_id'],$loanData['shipping_track_number'], $autoloan['loanId']);

			$deliveryData = [
				'loanId' =>  $autoloan['loanId'],
				'customer' => [
					'id'       => $user->id,
					'fullname' => $user->firstname . ' ' .$user->lastname,
					'mobileNumber' => $user->mobile,
					'billingAddress' => $user->address
				],

				'product' => [
					'id' => $code->id,
					'itemName' => $productName
				]
			];

			return $this->productDeliveryModel->store($deliveryData);
		}


		public function save_shiping_number($userid, $control_number, $loanId)
		{	

			$this->db->query(
				"SELECT * FROM fn_delivery_info
					where loanId = '$loanId'
					and userid = '$userid'
					and control_number = '$control_number'"
			);

			$res = $this->db->single();
			
			if(!$res){

				$this->db->query(
					"INSERT INTO `fn_delivery_info`(`userid`, `control_number`, `loanId`) 
					 VALUES ('$userid','$control_number','$loanId')");

	       		return $this->db->execute();
			}

			return true;
		}
		
	}