<?php

	class FNCodeInventoryModel extends Base_model
	{
		private $table_name = 'fn_code_inventories';
		public $table = 'fn_code_inventories';
		

		public function make_code_info($codeinfo)
		{

			extract($codeinfo);

			$status = 'available';

			$this->db->query(
				"INSERT INTO fn_code_storage(name  , box_eq , amount ,
				drc_amount , unilevel_amount , binary_point , distribution ,
				level , max_pair , status)

				VALUES('$name' , '$box_eq','$amount' , '$drc_amount' ,
				'$unilevel_amount' , '$binary_point' , '$distribution' ,
				'$level' , '$max_pair' , '$status')"
			);

			try{
				$this->db->execute();
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
		public function generate_codes($generateCodes)
		{
			extract($generateCodes);

			$counter = 0;

			$code  = $this->get_code_on_storage($codeid);

			$prefix = $this->make_activation_level_prefix($code->level);

			$make_query  = "";

			for($i = 0 ; $i < $quantity ; $i++)
			{
				$code = $this->make_activation_code($prefix);

				$make_query .= "
					INSERT INTO $this->table_name
					(code , branchid, box_eq,
					amount , drc_amount , unilevel_amount ,
					binary_point ,distribution,level ,
					max_pair , company , status)

					(SELECT '$code' , '$branchid' , box_eq, amount , drc_amount , unilevel_amount ,
					binary_point , distribution , level , max_pair , '$company' , status
					FROM fn_code_storage where id = '$codeid');";
			}

			try{

				$this->db->query($make_query);

				$this->db->execute();

				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());
				return false;
			}

		}


		public function get_code_on_storage($codeid)
		{
			$data = [
				'fn_code_storage' ,
				'*',
				" id = '$codeid'"
			];

			return 	$this->dbHelper->single(...$data);
		}

		public function get_code_storage_list()
		{
			$data = [
				'fn_code_storage' ,
				'*',
				null,
				' name asc'
			];

			return $this->dbHelper->resultSet(...$data);
		}

		public function get_list($params = null)
		{
			$this->db->query(
				"SELECT code.* , branch.name as branch_name
					FROM $this->table_name as code
					LEFT JOIN fn_branches as branch
					on code.branchid = branch.id
					$params"
			);

			return $this->db->resultSet();
		}


		public function getAssocWithLimit($field = null , $limit) 
		{
			$params = " order by $field asc LIMIT $limit";

			return $this->get_list($params);
		}
		public function getWithLimit($limit)
		{
			$params = " order by code.id desc LIMIT $limit";

			return $this->get_list($params);
		}


		public function getFiltered($where = null , $orderby = null, $limit = null)
		{	
			if(! is_null($where))
				$where = " WHERE {$where}";

			if(!is_null($orderby))
				$orderby = " ORDER BY {$orderby}";

			if(!is_null($limit))
				$limit = " LIMIT {$limit}";

			$params = " $where $orderby $limit";

			return $this->get_list($params);
		}

		public function get_totaL_code($branchId, $level)
		{
			$this->db->query(
				"SELECT count(*) as total FROM $this->table_name
				 WHERE branchid = '$branchId' AND level = '$level' AND status = 'available'  "
			);

			return $this->db->single()->total ?? 0;
		}


		public function get_branch_code($branchid)
		{
			$where = " WHERE code.branchid = '$branchid'";

			return
				$this->get_list($where);
		}


		public function getAvailableCodeByKey(array $keys)
		{

			$keys = parent::dbParamsToCondition($keys);

			$data = [
				$this->table_name,
				'*',
				$keys,
				'id desc',
				'1'
			];

			return $this->dbHelper->single(...$data);
		}
		public function get_available_code($branchid)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name
					WHERE branchid = '$branchid' AND
					status = 'available'
					order by id desc limit 1"
			);

			return $this->db->single();
		}

		public function get_available_code_by_level($branchid , $level, $quantity)
		{

			$this->db->query(
				"SELECT * FROM $this->table_name
					WHERE branchid = '$branchid' AND
					status = 'available' 
					and level = '$level'
					ORDER BY id DESC limit {$quantity}"
			);

			return $this->db->resultSet();
		}

		public function get_user_codes($userid)
		{
			$this->db->query(
				" SELECT off.created_at , off.userid ,codeinventory.* 
					FROM fn_off_code_inventories AS off 

					LEFT JOIN fn_code_inventories AS codeinventory
					ON codeinventory.id = off.codeid 

					WHERE off.userid = '{$userid}' 
					ORDER BY off.id desc "
			);
			return $this->db->resultSet();
		}


		public function get_code($boxid)
		{
			$this->db->query(
				"SELECT fncode.* , branch.name as branch_name
				FROM $this->table_name as fncode
				left join fn_branches as branch
				on branch.id = fncode.branchid 
				WHERE fncode.id = '$boxid'"
			);

			return
				$this->db->single('FNActivationCodeObj');
		}

		public function get_by_code($code)
		{
			$data = [
				$this->table_name ,
				'*',
				" code = '{$code}'"
			];

			return
				$this->dbHelper->single(...$data);
		}

		public function get_by_level($level)
		{
			$this->db->query(
				"SELECT * FROM `fn_code_storage` WHERE level = '$level'"
			);

			return $this->db->single();
		}

		private function make_activation_code($prefix)
		{
			$center = random_number(5);
			$suffix = random_number(2);

			//return random code;unique

			return strtoupper("{$prefix}-{$center}-{$suffix}");
		}

		private function make_activation_level_prefix($activationLevel)
		{
			return substr($activationLevel, 0 , 2);
		}



		public function releaseToUser($code , $userid)
		{
			$branch = Session::get('BRANCH_MANAGERS');

			$userModel = new User_model();

			$user = $userModel->get_user($userid);


			/*Check if purchasing code
			*is available on branch
			*/
			$availableCode = $this->getAvailableCodeByKey([
				'branchid' => $branch->branchid,
				'status'   => 'available',
				'level'    => $code->level
			]);

			/*If code is not available
			*Print Error
			*/
			if(!$availableCode) {
				Flash::set("No Available '{$availableCode->level}' code  to your branch " , 
					"danger" , 'code-release-error');
				return false;
			}

			$status = 'released';

			try{

				$saveCodeRelease = $this->dbHelper->insert(...[
					'fn_off_code_inventories',
					[
						'codeid' => $availableCode->id,
						'userid' => $user->id,
						'status' => $status
					]
				]);

				$updateCodeStatus = $this->update_status($availableCode->id , $status);

				if($saveCodeRelease && $saveCodeRelease) {
					Flash::set("You have recieved an activation code #{$availableCode->code} {$availableCode->level}" ,
					"info" , 'code-release-error');

					return true;
				}else{
					Flash::set("Fatal Error Please report to administrator / webmasters" ,
					"danger" , 'code-release-error');

					return false;
				}

			}catch(Exception $e)
			{
				Flash::set("Fatal Error Please report to administrator / webmasters" ,
					"danger" , 'code-release-error');
				return false;
			}

		}


		/*
		*FOR DELETION
		*new method this::releaseToUser()
		*This code is not optimized and triggerring bugs 
		*/
		public function release_code($userid)
		{
			$branch = Session::get('BRANCH_MANAGERS');

			$userModel = new User_model();

			$user = $userModel->get_user($userid);

			$availableCode = $this->get_available_code($branch->branchid);

			if(!$availableCode) {
				Flash::set("No Avaialble codes for your branch" , "danger" , 'code-release-error');
				return false;
			}

			$status = 'released';

			$this->db->query(
				"INSERT INTO fn_off_code_inventories(codeid , userid , status)
				VALUES('$availableCode->id' , '$user->id' , '$status')"
			);

			try{
				$this->db->execute();

				Flash::set("You have recieved an activation code #{$availableCode->code} {$availableCode->level}" ,
					"info" , 'code-release-error');

				$this->update_status($availableCode->id , 'released');

				return true;

			}catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

		public function update_status($codeid , $status)
		{
			$data = [
				$this->table_name,
				[
					'status' => $status
				],

				" id = '$codeid'"
			];

			return
				$this->dbHelper->update(...$data);
		}

		/*
		*Search Codes with the following parameters
		*/
		public function getCodeWith($keyPairs)
		{
			$WHERE = '';

			$counter = 0;
			$i       = 0;


			foreach($keyPairs as $key => $row)
			{
				if($counter < $i) {
					$WHERE .= " AND ";
					$counter++;
				}

				$WHERE .= "{$key} = '$row'";
				$i++;
			}

			$data = [
				$this->table ,
				'*',
				$WHERE,
				' id desc',
				'1'
			];

			return $this->dbHelper->single(...$data);
		}


















	}
