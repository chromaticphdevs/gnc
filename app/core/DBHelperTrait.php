<?php 	

	trait DBHelperTrait{

		public function DBinsert($db , $table , $fields){
			$keys = array_keys($fields);
			//store values
			$values = "";

			$counter = 1;
			for($i = 0 ; $i < count($keys) ; $i++){

				$values .= " :{$keys[$i]} ";
				if($counter < count($keys)) {
					$values .=" , ";
					$counter++;
				}
			}
			//generate dynaimic query
			$sql = "INSERT INTO $table (".implode(',', $keys).")";

			$sql .= " VALUES($values) ";

			$query = $db->query($sql);

			// //bind parameters
			foreach($keys as $key){
				$db->bind(":$key" , $fields[$key]);
			}


			if($db->execute()){

				return $db->lastInsertId();
			}
			else{
				var_dump_pre($db->errors());
				return false;
			}
		}

		public function DBselectById($db , $table , $id){

			$db->query( "SELECT * FROM $table where id = :id" );

			$db->bind(":id" , $id);

			return $db->single();
		}

		public function DBselectAll($db , $table , $limit = null) {

			$db->query( "SELECT * FROM $table ");

			return $db->resultSet();
		}
	} 