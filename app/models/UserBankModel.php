<?php 

    class UserBankModel extends Base_model
    {
        public $table = 'user_banks';
        const GOTYME_ID = '10';


        public function addNew($data) {
            if(!$this->validateAccountDetails($data)) {
                return false;
            } else {
                if(!$this->disableMultipleGoTymeAccount($data['user_id'], $data['organization_id'])){
                    return false;
                }
            }

            return parent::store([
                'account_number' => $data['account_number'],
                'user_id'   => $data['user_id'],
                'account_name'   => $data['account_name'],
                'organization_id'   => $data['organization_id']
            ]);
        }

        public function updateAccountDetails($accountDetails, $id) {
            if(!$this->validateAccountDetails($accountDetails)) {
                return false;
            } else {
                $bankDetails = $this->get([
                    'where' => [
                        'ub.id' => $id
                    ]
                ]);
                if(!$this->disableMultipleGoTymeAccount($bankDetails->user_id, $accountDetails['organization_id'])){
                    return false;
                }
            }
            return parent::dbupdate($accountDetails, $id);
        }

        public function validateAccountDetails($accountDetails) {

            if(empty($accountDetails['organization_id'] || $accountDetails['account_number']
                || $accountDetails['account_name'] )) {
                    $this->addError("All fields are required!");
                return false;
            }
            $bank = $this->get([
                'where' => [
                    'ub.account_number' => $accountDetails['account_number'],
                    'ub.organization_id' => $accountDetails['organization_id']
                ]
            ]);

            if($bank) {
                $this->addError("Bank details already owned by another user.");
                return false;
            }

            return true;
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE " .parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']} ";
            }

            if(!empty($params['limit'])) {
                $limit = " ORDER BY {$params['limit']} ";
            }

            $this->db->query(
                "SELECT ub.*, gm.meta_value as org_name 
                    FROM {$this->table} as ub
                    LEFT JOIN global_meta as gm 
                        ON ub.organization_id = gm.id
                    {$where} {$order} {$limit}"
            );
            return $this->db->resultSet();
        }

        public function get($params) {
            return $this->getAll($params)[0] ?? false;
        }

        /**
         * CHECK IF user has already existing gotyme bank account with us
         * then do not allow to create new one
         */
        private function disableMultipleGoTymeAccount($userId, $organizationId) {
            $goTyme = $this->getGotyme($userId);
            if($goTyme && isEqual($organizationId, $goTyme->organization_id)) {
                $this->addError("Multiple GoTyme Bank Account, unable to proceed action");
                return false;
            }

            return true;
        }
        public function getGotyme($userId) {
            return $this->get([
                'where' => [
                    'ub.user_id' => $userId,
                    'organization_id' => self::GOTYME_ID
                ]
            ]);
        }
    }