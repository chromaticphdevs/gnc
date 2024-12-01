<?php 	

	class FNItemInventory extends Controller
	{	

		public function __construct()
		{
			$this->itemInventoryModel = $this->model('FNItemInventoryModel');

			$this->branchModel = $this->model('FNBranchModel');

			/**
			 * Inventory Module products
			 */
			$this->product = $this->model('INProductModel');
		}

		public function make_item()
		{
			Authorization::setAccess(['admin']);

			if($this->request() === 'POST')
			{	
				$post = request()->inputs();
				/**
				 * PREVIOUS
				 * $result = 
				 *$this->itemInventoryModel->make_item($_POST);
				 */

				$result = $this->itemInventoryModel->store([
					'product_id' => $post['product_id'],
					'branchid' => $post['branchid'],
					'quantity' => $post['quantity'],
					'description' => $post['description'],
				]);

				Flash::set("Stock saved");

				if(!$result)
					flash_err();

				return redirect('FNItemInventory/make_item');
			}else{

				$data =[
					'title'    => 'Inventory Item' ,
					'branches' => $this->branchModel->get_list(),
					'total_items' => $this->itemInventoryModel->get_by_branch(),
					'items'    => $this->itemInventoryModel->get_list_decrease(),
					'products'  => $this->product->get_list_asc('name'),
				];
				
		
				return $this->view('finance/inventory/make_item' , $data);
			}
		}

		

		public function get_branch_inventory_with_name()
		{
			if(!Session::check('BRANCH_MANAGERS'))
		    {
		      die("Branch Manger must be logged in");
		    }

	      	$user = Session::get('BRANCH_MANAGERS');

	      	$userid = $user->id;

	      	$quantities = arr_layout_keypair( $this->itemInventoryModel->getGroupedQuantity_branch($user->branchid) , 'quantity' , 'quantity');
			$data =[
				'quantities' => $quantities ,
				'items'    =>  $this->itemInventoryModel->get_branch_inventory_with_name($user->branchid)
			];


			$this->view('finance/inventory/transactions' , $data);
		}


		public function get_transactions()
		{
			if(!Session::check('BRANCH_MANAGERS'))
		    {
		      die("Branch Manger must be logged in");
		    }

	      	$user = Session::get('BRANCH_MANAGERS');

	      	$userid = $user->id;

			$data =[
				'items'    => $this->itemInventoryModel->get_branch_inventory($user->branchid)
			];

			$this->view('finance/inventory/transactions' , $data);
		}


		public function get_logs_by_branch()
		{

			if($this->request() === 'POST')
			{
			 	$result = $this->itemInventoryModel->get_branch_logs($_POST['branchId']);

			 	echo json_encode($result);

			 
			}

		}

		public function get_branch_inventory_all($branchid)
		{
			

			$data =[
				'items' => $this->itemInventoryModel->get_branch_inventory_all(unseal($branchid))
			];

			$this->view('finance/inventory/branch_inventory' , $data);
		}


		public function search_user()
		{

			if(Session::check('BRANCH_MANAGERS'))
			{
				if($this->request() === 'POST')
				{

					$data = [
	                 	'userInfo' => $this->itemInventoryModel->search_user($_POST['userid'])
	           		];	
	           		$this->view('finance/inventory/upload_delivery_info' , $data);
		 
				}else{

		            $this->view('finance/inventory/upload_delivery_info');

				}
			}else{
				redirect('FNManager/login');
			}

		}


		public function upload_delivery_info()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{
				
				if($this->request() === 'POST')
				{		
					
					 $added_by = Session::get('BRANCH_MANAGERS');
					
					 $image = $this->upload_image_file($_FILES['image']);

					 $result = $this->itemInventoryModel->upload_delivery_info($_POST['userid'], $_POST['control_number'],$image,$added_by->id);

					 if($result)
					 {
					 	Flash::set("Image uploaded successfully");
						redirect('/FNItemInventory/search_user');
					 }
					 
				}

			}else{
				redirect('FNManager/login');
			}
		}

		public function get_delivery_info_for_user()
		{
				
			if(Session::check('USERSESSION'))
			{
				
				if($this->request() === 'POST')
				{		

					
				}else
				{	
					$userid = Session::get('USERSESSION')['id'];
		
					$data = [
	                 	'delivery_info' => $this->itemInventoryModel->get_delivery_info_for_user($userid)
	           		];	

					$this->view('finance/inventory/users_delivery_info',$data);

				}

			}else{
				redirect('users/login');
			}
		}

		private function upload_image_file($image)
		{
		   $file = new File();

            $file->setFile($image)
			->setPrefix('IMAGE')
			->setDIR(PUBLIC_ROOT.DS.'assets/delivery_image')
			->upload();

			if(!empty($file->getErrors())){

				Flash::set($file->getErrors(), 'danger');

				redirect('/FNItemInventory/search_user');

				return;
			}

			return $file->getFileUploadName();
		}


	}