<?php 

    class PettyCashTransactionModel extends Base_model
    {
        public $table = 'petty_cash_transactions';

        private function validateEntry($pettyData) {
            if(!empty($pettyData['amount'])) {
                if($pettyData['amount'] < 0) {
                    $errors [] = "Amount must be not less than 0";
                }
            }
            if(!empty($errors)) {
                foreach($errors as $key => $row) {
                    $this->addError($row);
                }
                return false;
            }
            return true;
        }

        private function convertAmount($amount, $entryType) {
            return isEqual($entryType, 'deduct') ? $amount * -1 : $amount;
        }

        /**
         * returns running balance
         */
        private function updateAccountPettyRecordReturnBalance($userId, $amount) {
            if(!isset($this->petty_user)) {
                $this->petty_user = model('PettyCashUserModel');
            }

            $petty_record = $this->petty_user->getCurrent($userId);

            if(!$petty_record) {
                $this->petty_user->store([
                    'user_id' => $userId,
                    'available_balance' => $amount,
                    'updated_at' => $dateToday
                ]);
                $running_balance = 0;
            } else {
                $running_balance = $petty_record->available_balance;
                $new_amount = $running_balance + $amount;
                $this->petty_user->dbupdate([
                    'available_balance' => $new_amount
                ], $petty_record->id);
            }

            return $running_balance;
        }
        public function add($petty) {
            $dateToday = today();
            if(!$this->validateEntry($petty)) {
                return false;
            }

            $amount = $this->convertAmount($petty['amount'], $petty['entry_type']);
            $running_balance = $this->updateAccountPettyRecordReturnBalance($petty['user_id'], $amount);

            return parent::store([
                'user_id' => $petty['user_id'],
                'amount'  => $amount,
                'entry_type' => $petty['entry_type'],
                'title' => $petty['title'],
                'description' => $petty['description'],
                'entry_date' => $petty['entry_date'],
                'running_balance' => $running_balance,
                'updated_at' => $dateToday,
                'created_by' => whoIs()['id']
            ]);
        }

        public function update($petty, $id) {
            if(!$this->validateEntry($petty)) {
                return false;
            }

            $amount = $this->convertAmount($petty['amount'], $petty['entry_type']);
            $this->updateAccountPettyRecordReturnBalance($petty['user_id'], $amount);

            $petty['updated_at'] = today();
            $petty['amount'] = $amount;
            return parent::dbupdate($petty, $id);
        }

        public function delete($id) {
            $pettyCash = $this->get($id);
            if($pettyCash) {
                //reconvert
                $this->updateAccountPettyRecordReturnBalance($pettyCash->user_id, ($pettyCash->amount * -1));
                parent::dbdelete($id);
                return true;
            }

            return false;
        }

        public function getAll($params = []) {

            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY ".$params['order'];
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT ".$params['limit'];
            }

            $this->db->query(
                "SELECT pct.*,concat(user.firstname, ' ',user.lastname) as fullname,
                    concat(uploader.firstname, ' ',uploader.lastname) as uploadername

                    FROM {$this->table} as pct
                    LEFT JOIN users as user
                    ON user.id = pct.user_id

                    LEFT JOIN users as uploader
                    ON uploader.id = pct.created_by
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            return $this->getAll([
                'where' => [
                    'pct.id' => $id
                ]
            ])[0] ?? false;
        }
    }