<?php 

	class LoanUniversalController extends Controller
	{

		public function __construct() {
			parent::__construct();

			$this->model = model('LoanUniversalModel');

		}

		public function index() {
			$data = [
				'loans' => $this->model->getAll()
			];
			return $this->view('loan_universal/index', $data);
		}

		public function create() {
			if(isSubmitted()) {
				$post = request()->posts();
				$isOkay = $this->model->create($post);

				if(!$isOkay) {
					Flash::set($this->model->getErrorString(),'danger');
					return request()->return();
				}
			}
			$data = [
				'products' => _products()
			];
			return $this->view('loan_universal/create', $data);
		}

		public function show($id) {
			$loanData = $this->model->get($id);
			
			$data = [
				'loan' => $loanData
			];

			if(!is_null($loanData->product_id)) {
				$data['product'] = _products()[$loanData->product_id];
			}

			return $this->view('loan_universal/show', $data);
		}
	}