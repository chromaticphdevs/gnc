<?php 	

	class FNBranch extends Controller
	{
		public function __construct()
		{
			Authorization::setAccess(['admin']);
			
			$this->branchModel = $this->model('FNBranchModel');
		}
		public function make_branch()
		{
			if($this->request() === 'POST')
			{
				$result = $this->branchModel->make_branch($_POST);

				if($result) {

					Flash::set("Branch has been created");
				}

				redirect('FNBranch/make_branch');
			}else{

				$data = [
					'title'    => 'Make-Branch' ,
					'branches' => $this->branchModel->get_list()
				];

				$this->view('finance/branch/make_branch' , $data);
			}
		}

		public function edit_branch($branchid)
		{

			if($this->request() === 'POST')
			{	
				$result = $this->branchModel->update_branch($_POST);

				if($result) {
					Flash::set("Branch Updated");
				}

				redirect("FNBranch/edit_branch/{$_POST['branchid']}");
			}else{
				$data = [
					'title'    => 'Edit Branch' ,
					'branchid' => $branchid,
					'branch'   => $this->branchModel->get_branch($branchid),
					'branches' => $this->branchModel->get_list()
				];

				$this->view('finance/branch/edit_branch' , $data);
			}
		}
	}
?>