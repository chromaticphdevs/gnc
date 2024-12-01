<?php

	class File
	{	
		private $_file;
		private $_ok_file_extension = ['jpeg' , 'jpg' , 'png' , 'bitmap','csv' , 'xls' ,'xlsx' , 'csv' ,'pdf','docx'];
		private $_ok_file_extension_office = ['jpeg' , 'jpg' , 'png' , 'bitmap','csv' , 'xls' ,'xlsx' , 'csv','pdf','docx'];
		private $_dir;
		private $_errors = [];

		private $_prefix = '';

		public function setOfficeFile($file = null)
		{
			$this->upload_type = 'notimage';

			try
			{
				if(!empty($file['error']))
				{
					throw new Exception("Error found on uploading");	
				}
				if(empty($file['name']))
				{
					throw new Exception("No File Found");
				}
				else
				{
					$this->_file = $file;
					$this->tmp_name = $file['tmp_name'];
					$this->name = $file['name'];
					
					//Extract extension on file name;
					$ext = explode('.', $this->name);
					//set file extension
					$this->ext = strtolower(end($ext));

					return $this;
				}
			}catch(Exception $e)
			{
				$this->addErrors($e->getMessage());
				return $this;
			}
		}
		public function setFile($file = null)
		{
			$this->upload_type = 'image';
			try
			{
				if(!empty($file['error']))
				{
					throw new Exception("Error found on uploading");	
				}
				if(empty($file['name']))
				{
					throw new Exception("No File Found");
				}
				else
				{
					$this->_file = $file;
					$this->tmp_name = $file['tmp_name'];
					$this->name = $file['name'];
					
					//Extract extension on file name;
					$ext = explode('.', $this->name);
					//set file extension
					$this->ext = strtolower(end($ext));

					return $this;
				}
			}catch(Exception $e)
			{

				$this->addErrors($e->getMessage());
				return $this;
			}
		}

		public function setDIR($dir)
		{
			$this->_dir = $dir;
			return $this;
		}

		public function upload()
		{
			try{
				if(is_null($this->_file))
				{
					$this->addErrors('No file uploaded');
					throw new Exception('File is null');
				}else
				{
					//check if extension is valid
					
					if($this->isValidExtension())
					{
						$this->uploadFile();
					}	
				}

			}catch(Exception $e)
			{
				return $e->getMessage();	
			}
		}
		public function setPrefix($_prefix)
		{
			$this->_prefix = $_prefix;
			return $this;
		}
		public function getNewName()
		{
			return $this->newname;
		}

		/** TO SUPPORT OLDER VERSION */
		public function getFileUploadName()
		{
			return $this->newname;
		}

		public function getName()
		{
			return $this->name;
		}
		private function isValidExtension()
		{
			if($this->upload_type == 'notimage') {
				return $this->isValidNotImage();
			}else{
				return $this->isValidImage();
			}
			
		}

		private function isValidNotImage()
		{
			if(in_array(strtolower($this->ext), $this->_ok_file_extension_office))
			{
				return true;
			}else
			{
				$this->addErrors('Invalid Extension : ' .$this->ext);
			}
			return false;
		}

		private function isValidImage()
		{
			if(in_array(strtolower($this->ext),$this->_ok_file_extension))
			{
				return true;
			}else
			{
				$this->addErrors('Invalid Extension : ' .$this->ext);
			}
			return false;
		}
		private function uploadFile()
		{
			$newName = $this->generateName();
			$path = $this->_dir;

			if(!file_exists($path)){
				mkdir($path);
			}
			
			if(move_uploaded_file($this->tmp_name,$this->_dir.'/'.$newName))
			{
				return true;
			}else{
				$this->addErrors('THE FILE IS NOT UPLOADED');
				return false;
			}

		}

		private function generateName()
		{
			return $this->newname = strtolower($this->_prefix.''.random_gen().'.'.$this->ext);
		}

		private function addErrors($err)
		{
			array_push($this->_errors, $err);
		}

		/** TO SUPPORT OLDER VERSION */
		public function getErrors()
		{
			return implode(',', $this->_errors);
		}

		public function errors()
		{
			return implode(',', $this->_errors);
		}
	}

