<?php 	
	
	namespace Core\Helpers;

	class StringHelper
	{

		public function __construct($string)
		{
			$this->string = $string;

			return $this;
		}

		public function clean()
		{
			$string = $this->string;

			$data = trim($string);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);

			return $data;
		}
	}	