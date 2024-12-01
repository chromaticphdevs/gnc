<?php 	

	class BinaryPointObj
	{

		public function __construct($point , $position)
		{
			$this->point    = $point;
			$this->position = $position;
		}

		public function get_point() {
			return $this->point;		
		}

		public function get_position() {
			return $this->position;
		}
	}