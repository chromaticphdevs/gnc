<?php 	

	class FNDownlineLevelAllModel extends Base_model
	{


		//listing all users that has a complete 2nd lvl downline that is all activated
		public function list_all_second_lvl()
		{
		
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();
				$left_counter = 0;
	    	 	$right_counter = 0;

				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_counter = $this->db->single()->number;
						}else 
						{
							$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_counter = $this->db->single()->number;

						}

					}

					if($left_counter == 2 && $right_counter == 2)
					{
						
						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
					}

				}

			}

			return $UserList;

		}

		//listing all users that has a complete 2nd lvl downline that is all activated
		public function list_by_branch_second_lvl($branch_id)
		{
		
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' and branchId = '$branch_id' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();
				$left_counter = 0;
	    	 	$right_counter = 0;

				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_counter = $this->db->single()->number;
						}else 
						{
							$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_counter = $this->db->single()->number;

						}

					}
					
					if($left_counter == 2 && $right_counter == 2)
					{
						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
					}

				}

			}
			return $UserList;

		}


		//listing all users that has a complete 3th lvl downline that is all activated
		public function list_all_third_lvl()
		{
		
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();

				$left_counter = 0;
	    	 	$right_counter = 0;
				$left_counter2 = 0;
	    	 	$right_counter2 = 0;
				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{	
								foreach ($left_result as $key3 => $value3) 
								{

									if($value3->L_R == "LEFT")
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value3->id'  ");
				    	 				$left_counter = $this->db->single()->number;
									}else 
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value3->id' ");
				    	 				$right_counter = $this->db->single()->number;

									}


								}
							}	

						}else 
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{	
								foreach ($right_result as $key4 => $value4) 
								{	
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value4->id'  ");
				    	 				$left_counter2 = $this->db->single()->number;
									}else 
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value4->id' ");
				    	 				$right_counter2 = $this->db->single()->number;

									}


								}
							}	

						}

					}

					if(($left_counter == 2 && $right_counter == 2) && ($left_counter2 == 2 && $right_counter2 == 2))
					{
						
						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
					}

				}

			}

			return $UserList;

		}


		//listing all users that has a complete 3th lvl downline that is all activated
		public function list_by_branch_third_lvl($branch_id)
		{
		
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' and branchId = '$branch_id' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();

				$left_counter = 0;
	    	 	$right_counter = 0;
				$left_counter2 = 0;
	    	 	$right_counter2 = 0;
				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{	
								foreach ($left_result as $key3 => $value3) 
								{

									if($value3->L_R == "LEFT")
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value3->id'  ");
				    	 				$left_counter = $this->db->single()->number;
									}else 
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value3->id' ");
				    	 				$right_counter = $this->db->single()->number;

									}


								}
							}	

						}else 
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{	
								foreach ($right_result as $key4 => $value4) 
								{	
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value4->id'  ");
				    	 				$left_counter2 = $this->db->single()->number;
									}else 
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value4->id' ");
				    	 				$right_counter2 = $this->db->single()->number;

									}


								}
							}	

						}

					}

					if(($left_counter == 2 && $right_counter == 2) && ($left_counter2 == 2 && $right_counter2 == 2))
					{
						
						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
					}

				}

			}

			return $UserList;

		}


		//listing all users that has a complete 4th lvl downline that is all activated
		public function list_all_fourth_lvl()
		{
			
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();

				$ids = [];

				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{	
								foreach ($left_result as $key3 => $value3) 
								{

									if($value3->L_R == "LEFT")
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id'  ");
				    	 			 	
				    	 				foreach ($this->db->resultSet() as $key10 => $value10) 
										{
										 	array_push($ids, $value10->id );
										}

									}else 
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id' ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key11 => $value11) 
										{
											array_push($ids, $value11->id );
										}


									}


								}
							}	

						}else 
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{	
								foreach ($right_result as $key4 => $value4) 
								{	
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id'  ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key12 => $value12) 
										{
											array_push($ids, $value12->id );
										}
									}else 
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id' ");
					    	 			foreach ($this->db->resultSet() as $key13 => $value13) 
										{
											array_push($ids, $value13->id );
										}
									}

								}
							}	

						}

					}


					if(count($ids) == 8)
					{	

						$downline_counter = [];

						for($row = 0; $row < 8; $row++)
						{

							$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$ids[$row]' ");
				    	 	array_push($downline_counter, $this->db->single()->number );

						}

						$count_value = 0;

						for($row = 0; $row < 8; $row++)
						{	
							if($downline_counter[$row] >= 2)
							{
								$count_value += 1;

							}

						}

						if($count_value == 8)
						{

							array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
						}


					}


				}

			}

			return $UserList;

		}

		//listing all users that has a complete 4th lvl downline that is all activated
		public function list_by_branch_fourth_lvl($branch_id)
		{
			
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' and branchId = '$branch_id' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();

				$ids = [];

				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{	
								foreach ($left_result as $key3 => $value3) 
								{

									if($value3->L_R == "LEFT")
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id'  ");
				    	 			 	
				    	 				foreach ($this->db->resultSet() as $key10 => $value10) 
										{
										 	array_push($ids, $value10->id );
										}

									}else 
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id' ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key11 => $value11) 
										{
											array_push($ids, $value11->id );
										}


									}


								}
							}	

						}else 
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{	
								foreach ($right_result as $key4 => $value4) 
								{	
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id'  ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key12 => $value12) 
										{
											array_push($ids, $value12->id );
										}
									}else 
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id' ");
					    	 			foreach ($this->db->resultSet() as $key13 => $value13) 
										{
											array_push($ids, $value13->id );
										}
									}

								}
							}	

						}

					}


					if(count($ids) == 8)
					{	

						$downline_counter = [];

						for($row = 0; $row < 8; $row++)
						{

							$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$ids[$row]' ");
				    	 	array_push($downline_counter, $this->db->single()->number );

						}

						$count_value = 0;

						for($row = 0; $row < 8; $row++)
						{	
							if($downline_counter[$row] >= 2)
							{
								$count_value += 1;

							}

						}

						if($count_value == 8)
						{

							array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
						}


					}


				}

			}

			return $UserList;

		}



		//listing all users that has a complete 5th lvl downline that is all activated
		public function list_all_fifth_lvl()
		{
			
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' "
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();

				$ids = [];

				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{	
								foreach ($left_result as $key3 => $value3) 
								{

									if($value3->L_R == "LEFT")
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id'  ");
				    	 			 	
				    	 				foreach ($this->db->resultSet() as $key10 => $value10) 
										{
										 	array_push($ids, $value10->id );
										}

									}else 
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id' ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key11 => $value11) 
										{
											array_push($ids, $value11->id );
										}


									}


								}
							}	

						}else 
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{	
								foreach ($right_result as $key4 => $value4) 
								{	
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id'  ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key12 => $value12) 
										{
											array_push($ids, $value12->id );
										}
									}else 
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id' ");
					    	 			foreach ($this->db->resultSet() as $key13 => $value13) 
										{
											array_push($ids, $value13->id );
										}
									}

								}
							}	

						}

					}


					if(count($ids) == 8)
					{	

						
						$ids2 = [];
						for($row = 0; $row < 8; $row++)
						{
							$this->db->query(" SELECT id FROM `users` WHERE upline = '$ids[$row]'  ");
				    	 				
	    	 				foreach ($this->db->resultSet() as $key14 => $value14) 
							{
								array_push($ids2, $value14->id);
							}

						}

						if(count($ids2) == 16)
						{	

							$downline_counter = [];

							for($row = 0; $row < 16; $row++)
							{	

								$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$ids2[$row]' ");
					    	 	array_push($downline_counter, $this->db->single()->number );

							}
			
							$count_value = 0;

							for($row = 0; $row < 16; $row++)
							{	
								if($downline_counter[$row] >= 2)
								{
									$count_value += 1;

								}

							}

							if($count_value == 16)
							{

								array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
							}

						}
						
					}


				}

			}
			return $UserList;

		}

		//listing all users that has a complete 5th lvl downline that is all activated
		public function list_by_branch_fifth_lvl($branch_id)
		{
			
			$this->db->query(
						"SELECT id,username,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' and branchId = '$branch_id'"
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{	
				

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->id'  ");

	    	 	$result = $this->db->resultSet();

				$ids = [];

				if(!empty($result))
				{	
					foreach ($result as $key2 => $value2) 
					{	
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{	
								foreach ($left_result as $key3 => $value3) 
								{

									if($value3->L_R == "LEFT")
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id'  ");
				    	 			 	
				    	 				foreach ($this->db->resultSet() as $key10 => $value10) 
										{
										 	array_push($ids, $value10->id );
										}

									}else 
									{

										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value3->id' ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key11 => $value11) 
										{
											array_push($ids, $value11->id );
										}


									}


								}
							}	

						}else 
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{	
								foreach ($right_result as $key4 => $value4) 
								{	
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id'  ");
				    	 				
				    	 				foreach ($this->db->resultSet() as $key12 => $value12) 
										{
											array_push($ids, $value12->id );
										}
									}else 
									{
										$this->db->query(" SELECT id FROM `users` WHERE upline = '$value4->id' ");
					    	 			foreach ($this->db->resultSet() as $key13 => $value13) 
										{
											array_push($ids, $value13->id );
										}
									}

								}
							}	

						}

					}


					if(count($ids) == 8)
					{	

						
						$ids2 = [];
						for($row = 0; $row < 8; $row++)
						{
							$this->db->query(" SELECT id FROM `users` WHERE upline = '$ids[$row]'  ");
				    	 				
	    	 				foreach ($this->db->resultSet() as $key14 => $value14) 
							{
								array_push($ids2, $value14->id);
							}

						}

						if(count($ids2) == 16)
						{	

							$downline_counter = [];

							for($row = 0; $row < 16; $row++)
							{	

								$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$ids2[$row]' ");
					    	 	array_push($downline_counter, $this->db->single()->number );

							}

							$count_value = 0;

							for($row = 0; $row < 16; $row++)
							{	
								if($downline_counter[$row] >= 2)
								{
									$count_value += 1;

								}

							}

							if($count_value == 16)
							{

								array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->address,$value->username) );
							}

						}
						
					}


				}

			}
			return $UserList;

		}




	}