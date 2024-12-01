<?php 	

	class BaseObj
	{
		public function __construct()
		{
			$this->class = __CLASS__;
		}

		public function set_prop($prop , $value)
		{
			if(property_exists(get_called_class(), $prop))
			{
				$this->$prop = $value;
			}else{
				die("Has no property {$prop}");
			}
		}

		public function get_prop($prop)
		{
			if(property_exists($this->class, $prop)) {
				return $this->$prop;
			}else{
				die("{$this->class} has no property {$prop} ");
			}
		}	
	}