<?php 	
	
	/*
	*Stores product delivery
	*of toc auto orders
	*/
	class ProductDeliveryModel extends Base_model
	{
		public static $type = 'in_code_libraries';//default change later

		public $table = 'product_deliveries';

		public function __construct()
		{
			parent::__construct();

			$this->deliveryItemModel = model('DeliveryItemModel');

			$this->loanModel = model('FNProductBorrowerModel');
		}

		public function getAll()
		{
			$deliveries = parent::dball();

			foreach($deliveries as $key => $delivery) {
				$delivery->items = $this->deliveryItemModel->getByDelivery($delivery->id);
				$delivery->loan  = $this->loanModel->dbget($delivery->track_id);
			}
			
			// dump($deliveries);

			return $deliveries;
		}

		public function store($data)
		{	
			$loanId = $data['loanId'];//loanid
			$customerData = $data['customer'];
			$productData = $data['product'];

			$reference = $this->token();

			

			$productDeliveryId = parent::store([
				'reference' => $reference,
				'track_id' => $loanId,
				'full_name' => $customerData['fullname'],
				'mobile_number' => $customerData['mobileNumber'],
				'billing_address' => $customerData['billingAddress']
			]);

			$productItem = $this->deliveryItemModel->store([
				'delivery_id' => $productDeliveryId,
				'product_id'  => $productData['id'],
				'type'        => self::$type,
				'item_name'   => $productData['itemName']
			]);

			if( $productDeliveryId && $productItem){
				$this->reference = $reference;
				return true;
			}

			return false;
		}

		public function token()
		{
			return random_number(12);
		}
	}