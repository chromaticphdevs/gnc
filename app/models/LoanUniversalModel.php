<?php 

	class LoanUniversalModel extends Base_model 
	{
		public $table = 'loans';

		public function create($loanData) {

			$this->userModel = model('User_model');
			//username
			$user = $this->userModel->dbget_single(
				parent::convertWhere(['username' => $loanData['loaner_name']])
			);

			if(!$user) {
				$this->addError("User not found.");
				return false;
			}

			if(isEqual($loanData['loan_type'], 'item_loan')) {
				if($loanData['item_quantity']) {
					if($loanData['item_quantity'] < 1) {
						$this->addError("Item quantity is not valid.");
						return false;
					}
				}

				$loanProduct = _products()[$loanData['product_id']];

				$loanAmount = $loanProduct['amount'] * $loanData['item_quantity'];

				return parent::store([
					'loan_reference' => $this->createReference(),
					'user_id' => $user->id,
					'processed_by' => whoIs()['id'],
					'date_of_entry' => date('Y-m-d'),

					'initial_amount' => $loanAmount,
					'balance' => $loanAmount,
					'product_id' => $loanData['product_id'],
					'item_quantity' => $loanData['item_quantity']
				]);
			} else {
				$loanAmount = $loanData['amount'];
				return parent::store([
					'loan_reference' => $this->createReference(),
					'user_id' => $user->id,
					'processed_by' => whoIs()['id'],
					'date_of_entry' => date('Y-m-d'),

					'initial_amount' => $loanAmount,
					'balance' => $loanAmount
				]);
			}
		}

		public function getAll($params = []) {
			$where = null;
			$order = null;

			if(!empty($params['where'])) {
				$where = " WHERE ".parent::convertWhere($params['where']);
			}

			$this->db->query(
				"SELECT loan.*, 
					concat(user.firstname , user.lastname) as loaner_name,
					user.username as loander_username 
					
					FROM {$this->table} as loan
					
					LEFT JOIN users as user
					ON user.id = loan.user_id
					{$where}{$order} "
			);

			return $this->db->resultSet();
		}

		private function createReference() {
			return random_number(10);
		}

		public function get($id) {
			return $this->getAll([
				'where' => [
					'loan.id' => $id
				]
			])[0] ?? false;
		}
	}