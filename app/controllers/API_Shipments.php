<?php 	

	class API_Shipments extends Controller
	{

		public function __construct()
		{
			$this->productRelease = model('FNProductReleaseModel');
			$this->logistic = model('LogisticModel');
		}
		public function index()
		{
			$productReleases = $this->productRelease->getCompleteMeta();

			ee(api_response($productReleases));
		}

		public function get($id)
		{
			$productRelease = $this->productRelease->getCompleteMetaById($id);

			ee(api_response($productRelease));
		}

		public function updateStatus()
		{
			$post = request()->inputs();

			$this->productRelease->updateLogisticStatus($post['id'] , $post['status']);
		}

		public function addToLogistics()
		{
			$inputs = request()->inputs();


			if(! isset($inputs['order_id'] , $inputs['reference']))
			{
				ee(api_response('Invalid Request' , false));
				return false;
			}

			$result = $this->logistic->store([
				'type' => 'product-release',
				'order_id' => $inputs['order_id'],
				'logistic_reference' => $inputs['reference'],
			]);

			if($result) {
				ee(api_response('success'));
			}else{
				ee(api_response('fatal errorr' , false));
			}
		}
	}