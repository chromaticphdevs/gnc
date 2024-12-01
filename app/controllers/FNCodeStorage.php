<?php 	

	class FNCodeStorage extends Controller
	{	
		public function __construct()
		{
			$this->codestorage = $this->model('FNCodeStorageModel');
			$this->product = $this->model('INProductModel');
			$this->activationLevels = activationlevels();
			$this->code_library_category = code_library_category();
		}

		public function index()
		{
			$data = [
				'codelibraries' => $this->codestorage->get_code_lib_all()
			];
			
			return $this->view('finance/codelibraries/index' , $data);
		}

		public function create()
		{
			//'activationLevels' => $this->activationLevels
			$data = [
				'title' => 'Code Libraries',
				'products' => $this->product->dball(),
				'codelibraries' => $this->codestorage->dbget_assoc('name'),
				'code_library_category' => 	$this->code_library_category 			
			];

			return $this->view('finance/codelibraries/create_new' , $data);
		}

		public function store()
		{
			$post = request()->inputs();

			$result = $this->codestorage->store([
				'name' => $post['name'],
				'box_eq' => $post['box_eq'],
				'amount' => $post['amount'],
				'drc_amount' => $post['drc_amount'],
				'unilevel_amount' => $post['unilevel_amount'],
				'binary_point' => $post['binary_point'],
				'distribution' => $post['distribution'],
				'level' => $post['level'],
				'max_pair' => $post['max_pair'],
				'status' => $post['status'],
			]);

			Flash::set( " Code library {$post['name']} saved");

			if(!$result)
				flash_err();

			return redirect("FNCodeStorage");
		}

		public function store_new()
		{
			$post = request()->inputs();

			$code_lib_info=$this->codestorage->get_code_lib_info($post['code_id']);

			$result = $this->codestorage->save_code_lib($post['product_id'],$code_lib_info,$post['oroginal_price'],
														$post['discounted_price'],$post['code_category']);

			Flash::set( " Code library saved");

			if(!$result)
				flash_err();

			return redirect("FNCodeStorage");
		}
	}
