<?php 

    class CashAdvanceCoBorrowerModel extends Base_model
    {
        public $table = 'cash_advance_co_borrowers';
        public $_fillables = [
            'fn_ca_id',
            'co_borrower_id',
            'co_borrower_approval',
            'staff_approval',
            'benefactor_id'
        ];

        const MAX_COBORROW = 3;

        public function addNew($data) {
            $fillableDatas = parent::getFillables($data);
            //check if 
            $instances = parent::dbget_assoc('id', parent::convertWhere([
                'co_borrower_id' => $fillableDatas['co_borrower_id']
            ]));

            if(count($instances) > self::MAX_COBORROW) {
                $this->addError("Co Borrower reached its maximum loan involvement.");
                return false;
            }

            return parent::store($fillableDatas);
        }

        public function processApproval($id, $approval, $approvalRemarks) {
            $resp = parent::dbupdate([
                'co_borrower_approval' => $approval,
                'co_borrower_remarks' => $approvalRemarks
            ], $id);

            if($resp) {
                if(!isset($this->userNotificationModel)) {
                    $this->userNotificationModel = model('UserNotificationModel');
                }

                if(!isset($this->FNCashAdvanceModel)) {
                    $this->FNCashAdvanceModel = model('FNCashAdvanceModel');
                }

                $instance = $this->get([
                    'where' => [
                        'cacb.id' =>  $id
                    ]
                ]);
                
                $message = "You're Loan Co-borrower invitation has been accepted by {$instance->first_name}";
                $link = '/CashAdvance/loan/'.seal($instance->id);

                $loanInstance = $this->FNCashAdvanceModel->getLoan($id);

                $this->userNotificationModel->store([
                    'message' => $message,
                    'link'    => $link,
                    'user_id'  => $loanInstance->userid
                ]);

                return $resp;
            }

            return false;
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ". parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER {$params['order']} ";
            }

            if(!empty($params['limit'])) {
                $limit = " limit {$params['limit']} ";
            }

            $this->db->query(
                "SELECT fnca.*, user.*, cacb.*,
                    cacb.id as id 
                    FROM {$this->table} as cacb
                    LEFT JOIN users as user
                        ON user.id = cacb.co_borrower_id

                    LEFT JOIN fn_cash_advances as fnca
                        ON fnca.id = cacb.fn_ca_id
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($params = []) {
            return $this->getAll($params)[0] ?? false;
        }
    }