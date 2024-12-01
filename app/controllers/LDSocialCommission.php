<?php 	

	class LDSocialCommission extends Controller
	{


		public function __construct()
		{
			$this->socialCommissionModel = $this->model('LDSocialCommissionModel');

			$this->productModel = $this->model('Product_model');
		}

		public function index()
		{
			$productid = 3;//

			$dbbipurchaserid = 321;//

			$product  = $this->productModel->get_product_by_id($productid);

			$sponsors = $this->socialCommissionModel->get_sponsors($dbbipurchaserid);

			$uplines  = $this->socialCommissionModel->get_uplines($dbbipurchaserid);


			$this->socialCommissionModel->post_commissions($dbbipurchaserid , $product);
		}
	}