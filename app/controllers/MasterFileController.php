<?php 

	class MasterFileController extends Controller
	{
		public function __construct() {
			parent::__construct();

			$this->personalModel = model('PersonalDataModel');
			$this->userModel = model('User_model');	
			$this->beneficiaryModel = model('BeneficiaryModel');

			$this->whoIs = whoIs();	
		}
		public function create() {
			
			$req  = request()->inputs();
			$post = request()->posts();

			if (isSubmitted()) {

				$_fillables['status'] = 'pending';
				$post = request()->posts();
				$isOkay = $this->personalModel->createOrUpdate($post);

				if($isOkay) {
					Flash::set("Success");
					return redirect('MasterFileController/show');
				}else{
					Flash::set($this->personalModel->getErrorString(), 'danger');
					return request()->return();
				}
			}

			$user = $this->userModel->get_user($this->whoIs['id']);
			$data = [
				'user' => $user,
				'post' => $post
			];
			return $this->view('master_file/create', $data);
		}

		public function beneficiaryCreate() {
			$req  = request()->inputs();
			$post = request()->posts();

			if(isSubmitted()) {
				$isOkay = $this->beneficiaryModel->createOrUpdate($post);
				if($isOkay) {
					Flash::set("Master list created");
					return redirect("MasterFileController/show");
				} else {
					Flash::set($this->beneficiaryModel->getErrorString(), 'danger');
					return request()->return();
				}
			}

			$user = $this->userModel->get_user($this->whoIs['id']);
			$data = [
				'user' => $user,
				'post' => $post
			];

			return $this->view('master_file/beneficiary_create', $data);
		}

		public function show($id = null) {
			if (is_null($id)) {
				$id = $this->whoIs['id'];
			}

			$personal = $this->personalModel->get($id);
			$data = [
				'personal' => $personal
			];
			return $this->view('master_file/show', $data);
		}
	}