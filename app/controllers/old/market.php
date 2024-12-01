<?php 	
	use shop\classes\CartItem;

	class Market extends Controller{

		private $cart_items = null;


		public function __construct()
		{
			$this->market_model = $this->model('market_model');
			$this->product_model = $this->model('product_model');
			$this->cart_model = $this->model('cart_model');

			//get cart items

			if(Session::check('CARTSESSION'))
			{
				$this->cart_items = $this->get_cart_items();
			}
		}

		public function catalog()
		{	

			if(isset($_GET['keyword'])){

				$keyword = filter_var($_GET['keyword'] , FILTER_SANITIZE_STRING);
				$data = [
					'product_list' => $this->product_model->get_products_with_key(['keyword' => $keyword])
				];

				$this->view('market/catalog' , $data);
			}
			// }else{
			// 	redirect('market/index');
			// }
		}
		public function index()
		{
			#check if there is an account logged in
			if(is_logged_in())
			{
				$data = [
					'product_list' => $this->product_model->get_list()
				];
				
				$this->view('market/index' , $data);
			}else{
				$data = [
					'product_list' => $this->product_model->get_list()
				];

				$this->view('market/index' , $data);
			}
		}

		public function get_products()
		{
			#check if there is an account logged in

			$limit = $_POST['limit'];
			$start = $_POST['start'];


			$data = [
				'product_list' => $this->market_model->get_products(['limit' => $limit , 'start' => $start])
			];

			echo json_encode($data);
		}

		public function view_product(int $product_id)
		{

			$data = [
				'product' => $this->product_model->get_product_by_id($product_id) ,
				'cart_items' => $this->cart_items
			];

			// $cartItem = new CartItem();


			$this->view('market/product_view' , $data);
		}

		private function get_cart_items()
		{
			$cart_id = Session::get('CARTSESSION')['id'];

			return $this->cart_model->get_cart_items($cart_id);
		}
	}