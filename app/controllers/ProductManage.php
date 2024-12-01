<?php

	class ProductManage extends Controller
	{
		public function __construct()
		{
			$this->load_model('product_manage_model' , 'product_model');
		}
		public function updateAll()
		{
			$res = $this->product_model->updateAll($_POST);
			if($res){
				Flash::set('product updated');
				redirect('storeProduct/list');
			}else{
				
				var_dump($res);
			}
		}
		/**/
		public function updateName()
		{
			$res = $this->product_model->updateName($_POST);
			if($res)
			{
				echo 'TRUE';
				return true;
			}else
			{
				echo 'FALSE';
				return false;
			}
		}

		public function updateImage()
		{

			if($this->request() === 'POST')
			{
				$file = new File();
				$file->setFile($_FILES['image'])
				->setPrefix('IMAGE')
				->setDIR(PUBLIC_ROOT.DS.'assets')
				->upload();

				if(!empty( $file->getErrors() )){
					Flash::set($file->getErrors() , 'danger');
					redirect('storeProduct/list');
				}					
				else
				{	
					$res = $this->product_model->updateImage($_POST , $file->getFileUploadName());

					redirect('storeProduct/list');
				}
			}
		}
		public function updateField()
		{
			$res = false;
			
			switch (strtolower($_POST['field'])) {
				case 'name':
					$res = $this->product_model->updateName($_POST);
					break;
				case 'price':
					$res = $this->product_model->updatePrice($_POST);
					break;
				case 'quantity':
					$res = $this->product_model->updateQuantity($_POST);
					break;ak;
				case 'drc_amount':
					$res = $this->product_model->updateDRC($_POST);
					break;
				case 'unilvl_amount':
					$res = $this->product_model->updateUNILVL($_POST);
					break;
				case 'bp_amount':
					$res = $this->product_model->updateBP_AMOUNT($_POST);
					break;

				case 'max_pair':
					$res = $this->product_model->update_maxpair($_POST);
					break;
					
			}
			if($res)
			{
				echo $res;
				// return true;
			}else{
				echo $res;
				// return false;
			}
		}

		public function duplicate()
		{
			$res = $this->product_model->duplicate($_POST);

			if($res)
			{
				echo 'TRUE';
				return true;
			}else{
				echo 'FALSE';
				return false;
			}
		}
	}