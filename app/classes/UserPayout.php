<?php
namespace app\Classes
{
	class UserPayout
	{
		private $_db;
		private $_userid;

		private $_start;
		private $_end;

		public function __construct($userid , $database)
		{
			$this->_userid = $userid;
			$this->_db = $database;
		}

		/**
		*@param $start and $end are both dates.
		*/
		public function getCommissions($start , $end)
		{
			$this->_start = $start;
			$this->_end   = $end;

			// return $this->_start;
			return $this->add($this->getBinaryCommission() , $this->getSponsorCommission());
		}
		/**
		*@param $start and $end are both dates.
		*/
		public function getBinaryCommission()
		{
			$this->_db->query(
				"SELECT sum(ifnull(amount,0)) as total from binary_pv_commissions where user_id = :user_id 
				and dt > :start"
			);

			$this->_db->bind(':user_id' , $this->_userid);
			$this->_db->bind(':start' , $this->_start);

			$res = $this->_db->single();

			if(!empty($res))
				return $this->stdToNumber($res , 'total');
			return 0;
		}
		/**
		*@param $start and $end are both dates.
		*/
		public function getSponsorCommission()
		{
			$this->_db->query(
				"SELECT sum(ifnull(amount,0)) as total from commissions where c_id = :user_id 
				and dt > :start"
			);

			$this->_db->bind(':user_id' , $this->_userid);
			$this->_db->bind(':start' , $this->_start);

			$res = $this->_db->single();

			if(!empty($res))
				return $this->stdToNumber($res , 'total');
			return 0;
		}

		/**
		*@param
		*/

		public function getDrc()
		{
			$this->_db->query(
				"SELECT sum(ifnull(amount,0)) as total from commissions where c_id = :user_id 
				and dt between :start and :date_end and type = 'DRC'"
			);

			$this->_db->bind(':user_id' , $this->_userid);
			$this->_db->bind(':start' , $this->_start);
			$this->_db->bind(':date_end', $this->_end);

			$res = $this->_db->single();

			if(!empty($res))
				return $this->stdToNumber($res , 'total');
			return 0;
		}

		public function getMentor()
		{
			$this->_db->query(
				"SELECT sum(ifnull(amount,0)) as total from commissions where c_id = :user_id 
				and dt between :start and :date_end and type = 'MENTOR'"
			);

			$this->_db->bind(':user_id' , $this->_userid);
			$this->_db->bind(':start' , $this->_start);
			$this->_db->bind(':date_end', $this->_end);

			$res = $this->_db->single();

			if(!empty($res))
				return $this->stdToNumber($res , 'total');
			return 0;
		}



		public function getUnilvl()
		{
			$this->_db->query(
				"SELECT sum(ifnull(amount,0)) as total from commissions where c_id = :user_id 
				and dt between :start and :date_end and type = 'UNILVL'"
			);

			$this->_db->bind(':user_id' , $this->_userid);
			$this->_db->bind(':start' , $this->_start);
			$this->_db->bind(':date_end', $this->_end);

			$res = $this->_db->single();

			if(!empty($res))
				return $this->stdToNumber($res , 'total');
			return 0;
		}

		
		
		private function stdToNumber($std , $name)
		{
			if($std->$name <= 0)
				return 0;
			return $std->$name;
		}

		private function add($a , $b)
		{
			return $a+$b;
		}
	}
}
	