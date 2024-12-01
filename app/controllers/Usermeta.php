<?php 	
	use Services\UserService;
	load(['UserService'], APPROOT.DS.'services');
	
	class Usermeta extends Controller
	{

		public function __construct()
		{
			$this->model = model('UsermetaModel');
			$this->globalMetaModel = model('GlobalMetaModel');
			$this->userService = new UserService;
			$this->whoIs = whoIs();

			$this->bankNames = arr_layout_keypair($this->globalMetaModel->all(['where' => ['category' => 'BANK_NAME']]), 'meta_value', 'meta_value');
		}


		public function create() {
			$req = request()->inputs();
			if (isSubmitted()) {
				$req = $this->validateIfBankEntry($req);
				$res = $this->model->save($req);
				if(!$res) {
					Flash::set($this->model->getErrorString(), 'danger');
					return request()->return();
				} else {
					Flash::set($this->model->getMessageString());
					return redirect('FinancialStatementController');
				}
			}

			return $this->view('usermeta/create', [
				'userService' => $this->userService,
				'userid' => $this->whoIs['id'],
				'bankNames' => $this->bankNames
			]);
		}

		private function validateIfBankEntry($req) {
			$metaAttribute = $req['meta_attribute'] ?? [];
			//bank entry
			if (isEqual($req['meta_key'], 'bank')) {
				if (isEqual($metaAttribute['bank_org'], 'other')) {
					//check if bank others is empty
					if(empty($req['bank_others'])) {
						Flash::set("If bank is selected, then bank or or bank others must not be empty");
						return request()->return();
					} else {
						//add to bank list
						$this->globalMetaModel->save([
							'category' => 'BANK_NAME',
							'meta_value' => $req['bank_others']
						]);
						$metaAttribute['bank_org'] = $req['bank_others'];
					}
				}
			}
			$req['meta_attribute'] = $metaAttribute;

			return $req;
		}

		public function edit($id) {
			$req = request()->inputs();
			$umeta = $this->model->get($id);

			if (isSubmitted()) {
				$req = $this->validateIfBankEntry($req);
				$res = $this->model->save($req, $req['id']);
				if(!$res) {
					Flash::set($this->model->getErrorString(), 'danger');
					return request()->return();
				} else {
					Flash::set($this->model->getMessageString());
					return redirect('FinancialStatementController');
				}
			}
			return $this->view('usermeta/edit', [
				'userService' => $this->userService,
				'userid' => $this->whoIs['id'],
				'uMeta' => $umeta,
				'bankNames' => $this->bankNames
			]);
		}


		public function index()
		{
			$metas = [];
			$data = [
				'title' => 'UsersMeta',
				'metas' => $metas
			];
			
			return $this->view('usermeta/index', $data);
		}

		public function store()
		{
			$q = request()->inputs();

			$r = $this->model->store([
				'user_id'    => $q['userId'],
				'meta_key'   => 'SCREENING_NOTES', //this must have a constant value
				'meta_value' => $q['metaValue']
			]);
		}

		public function delete($id) {
			$req = request()->inputs();
			$this->model->dbdelete($id);

			if(isset($req['returnTo'])) {
				return redirect(unseal($req['returnTo']));
			}else{
				return request()->return();
			}
		}
	}