<?php
	//get product loan with - w/out comments 
	class FNProductBorrowerCXModel extends Base_model
	{

		public function __construct()
		{
			$this->productRelease = model('FNProductBorrowerModel');
			$this->loanPayment = model('FNProductReleasePaymentModel');

			$this->socialMedia = model('UserSocialMediaModel');

			$this->noteModel = model('FNProductLoanNoteModel');
		}
		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

		public function getCalled()
		{

			$this->set_time_zone();

			$this->db->query(
				"SELECT pr.*,
				 CONCAT(u.firstname,' ',u.lastname) as fullname,u.username,u.email,u.mobile,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment,
				 ifnull((SELECT link FROM user_social_media WHERE userid = u.id AND status='verified' AND type='Facebook' LIMIT 1),'no_link') as valid_link
				 FROM `fn_product_release` AS pr INNER JOIN users as u
				 WHERE u.id=pr.userid AND pr.branchId = '$branchId' and pr.status = '$status'

				 ORDER BY pr.id desc"
	        );

		}

		public function getUncalled()
		{

		}

		/**
		 * Get users by status 
		 */
		public function getMeta($parameters = [])
		{
			$branchId = isset($parameters['branchId']) ? $parameters['branchId'] : null;
			$status = isset($parameters['status']) ? $parameters['status'] : null;

			$WHERE = null;

			if( is_null($branchId) && is_null($status)) 
			{
				$WHERE = "WHERE product_release.branchId = '$branchId'
				AND product_release.status = '$status'";
			}
			//product release
			 $this->productRelease->db->query(
				"SELECT product_release.* ,  concat(u.firstname , ' ' , u.lastname ) 
					AS fullname , u.username , u.email , u.mobile , u.created_at as registered_at

					FROM {$this->productRelease->table} as product_release 

					LEFT JOIN users as u
					ON u.id = product_release.userid 
					$WHERE
					ORDER BY product_release.id desc "
			);
			 //store product release
			$productReleases = $this->productRelease->db->resultSet();

			 //initiate payment table
			$paymentTable = $this->loanPayment->table;

			/*
			*Loop product release
			*store loanpayments [ total , list ]
			*store social media link
			*/

			$productReleasesLoop = $productReleases;


			foreach($productReleasesLoop as $key => $productRelease) 
			{
				$productRelease->payment = [
					'total' => 0 ,
					'list'  => []
				];

				/*GET ALL LOAN PAYMENTS WHERE ID */
				$this->loanPayment->db->query(
					"SELECT * FROM {$paymentTable} as payment
						WHERE payment.loanId = '{$productRelease->id}' "
				);
				//store payment list
				$productRelease->payment['list'] =  $this->loanPayment->db->resultSet();

				//add all payment list
				foreach($productRelease->payment['list'] as $key => $row) {
					$productRelease->payment['total'] += $row->amount;
				}

				//get notes
				$user_notes = $this->noteModel->getByLoan($productRelease->id);

				//if has valid social media then store link
				if($user_notes) {
					$productRelease->notes = $user_notes;
				}else{
					$productRelease->notes = 'no_note';
				}

				//preapre social media link
				$this->socialMedia->db->query(
					"SELECT link FROM user_social_media WHERE userid = {$productRelease->userid} AND status='verified' AND type='Facebook' LIMIT 1"
				);

				//preapre social media link
				$socialMedia = $this->socialMedia->db->single();

				//if has valid social media then store link
				if($socialMedia) {
					$productRelease->valid_social_media = $socialMedia->link;
				}else{
					$productRelease->valid_social_media = 'no_link';
				}
			}

			 return $productReleases;
		}


		public function getBorrowDetails($userId, $loanId)
		{
			//product release
			$this->productRelease->db->query(
				"SELECT product_release.* ,  concat(u.firstname , ' ' , u.lastname ) 
					AS fullname , u.username , u.email , u.mobile, u.address ,
					u.created_at as registered_at

					FROM {$this->productRelease->table} as product_release 

					LEFT JOIN users as u
					ON u.id = product_release.userid 

					WHERE product_release.userid = '$userId'
					AND product_release.id = '$loanId' 

					ORDER BY product_release.id desc "
			);
			 //store product release
			$productReleases = $this->productRelease->db->resultSet();
			$paymentTable = $this->loanPayment->table;

			foreach($productReleases as $key => $productRelease) 
			{
				$productRelease->payment = [
					'total' => 0 ,
					'list'  => []
				];

				/*GET ALL LOAN PAYMENTS WHERE ID */
				$this->loanPayment->db->query(
					"SELECT * FROM {$paymentTable} as payment
						WHERE payment.loanId = '{$productRelease->id}' "
				);
				//store payment list
				$productRelease->payment['list'] =  $this->loanPayment->db->resultSet();

				//add all payment list
				foreach($productRelease->payment['list'] as $key => $row) {
					$productRelease->payment['total'] += $row->amount;
				}

				//get notes
				$user_notes = $this->noteModel->getByLoan($productRelease->id);

				//if has valid social media then store link
				if($user_notes) {
					$productRelease->notes = $user_notes;
				}else{
					$productRelease->notes = 'no_note';
				}

				//preapre social media link
				$this->socialMedia->db->query(
					"SELECT link FROM user_social_media WHERE userid = {$productRelease->userid} AND status='verified' AND type='Facebook' LIMIT 1"
				);

				//preapre social media link
				$socialMedia = $this->socialMedia->db->single();

				//if has valid social media then store link
				if($socialMedia) {
					$productRelease->valid_social_media = $socialMedia->link;
				}else{
					$productRelease->valid_social_media = 'no_link';
				}
			}

			return $productReleases;
		}

	}
