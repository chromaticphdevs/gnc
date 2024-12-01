<?php

	class Geneology_model extends Base_model
	{

		public function update($userid , $newupline)
		{
			$this->db->query(
				"UPDATE users set upline = '$newupline' where id = '$userid'"
			);

			if($this->db->execute())
				return TRUE;
			return FALSE;
		}

		public function getUnilevel($userid)
		{
			$this->db->query(
				"SELECT * FROM users as user
					WHERE direct_sponsor = '$userid'
				"
			);

			return $this->db->resultSet();
		}

		public function getUnilevelWithSocialMediaAccount($userid , $mediaType)
		{
			$this->db->query("SET time_zone = '+08:00'");
      $this->db->execute();

			$this->db->query(
				"SELECT user.*, concat(user.firstname , ' ' , user.lastname) as fullname,
					(SELECT link from user_social_media
						where userid = user.id and type = '$mediaType' LIMIT 1) as fb_link,
					(SELECT  concat(firstname , ' ' , lastname) FROM users as team_adviser 
					WHERE team_adviser.id = user.upline) as team_adviser_name
					FROM users as user
					WHERE direct_sponsor = '$userid' and username != 'breakthrough' and username != 'duplicate' 
					ORDER BY user.id desc
				"
			);


			return $this->db->resultSet();
		}

		public function getUnilevelWithSocialMediaAccountAndActivated($userid , $mediaType)
		{
			$this->db->query("SET time_zone = '+08:00';");
      		$this->db->execute();

			$this->db->query(	
				"SELECT user.*, concat(user.firstname , ' ' , user.lastname) as fullname,
					(SELECT link from user_social_media
						where userid = user.id and type = '$mediaType' LIMIT 1) as fb_link
					FROM users as user

					WHERE direct_sponsor = '$userid' and user.status != 'pre-activated'

					ORDER BY user.id desc
				"
			);
			return $this->db->resultSet();
		}

		public function getUnilevelWithSocialMediaAccountAndPreActivated($userid , $mediaType, $status)
		{
			$this->db->query("SET time_zone = '+08:00';");
      		$this->db->execute();

			$this->db->query(	
				"SELECT user.*, concat(user.firstname , ' ' , user.lastname) as fullname,
					(SELECT link from user_social_media
						where userid = user.id and type = '$mediaType' LIMIT 1) as fb_link
					FROM users as user

					WHERE direct_sponsor = '$userid' and user.status = '$status'

					ORDER BY user.id desc
				"
			);
			return $this->db->resultSet();
		}


		public function getUnilevelTree($userid)
		{
			$hasSponsor = false;

			$tree = [];
			do{
				$this->db->query(
					"SELECT id , direct_sponsor , username FROM users
						WHERE id = '$userid'"
				);
				$user = $this->db->single();

				if(empty($user) || !$user) {
					$hasSponsor = false;
				}else{
					$hasSponsor = true;
					$userid  = $user->direct_sponsor;
					array_push($tree , $user);
				}
			}while($hasSponsor);


			return $tree;
		}


		public function add_user($uplineid , $userid , $position)
		{
			$this->db->query(
				"UPDATE
					users set upline = '$uplineid'  , L_R = '$position' ,
					is_activated = true
						WHERE id = '$userid' "
			);

			try{

				$this->db->execute();
				$upline = $this->userModel->get_user($uplineid);
				$user   = $this->userModel->get_user($userid);

				Flash::set("'$upline->username' is now upline of user '$user->username'");
				return true;

			}catch(Exception $e) {
				Flash::set($e->getMessage() , 'danger');
				return false;
			}
		}

		private function getSponsoredAccounts($mainUserSponsoredUsers)
		{
			$sponsoredUserList = array();

			if(empty($mainUserSponsoredUsers)){

				return array();

			}else
			{
				foreach($mainUserSponsoredUsers as $user)
				{
					if(isset($user->id))
					{
						$userSponsored = $this->getUserSponsored($user->id);

						array_push($sponsoredUserList, $userSponsored);
					}

				}

				return $sponsoredUserList;
			}


		}

		private function getUserSponsored($userid)
		{
			$sql = "SELECT * FROM users where direct_sponsor = '$userid'";

			$this->db->query($sql);

			$res=  $this->db->resultSet();

			if($res)
				return $res;
			return '';
		}
	}
