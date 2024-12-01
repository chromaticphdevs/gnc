<?php 

    class LoanQualifierModel extends Base_model
    {
        public $table = 'loan_qualifiers';
        public $_fillables = [
            'user_id',
            'loan_type',
            'loan_amount',
            'approval_date',
            'approvel_type',
            'requirements',
            'approved_by'
        ];

        public function approve($loanData, $id = null) {
            $isExist = parent::dbget_single(parent::convertWhere([
                'user_id' => $loanData['user_id']
            ]));

            if (!$isExist) {
                $_fillables = parent::getFillables($loanData);
                return parent::store($_fillables);
            } else {
                $this->addError("Unable to approve loan.");
                return false;
            }
            
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            
            if (isset($params['where'])) {
                $where = " WHERE ".parent::convertWhere($params['where']);
            }

            if (isset($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            $this->db->query(
                "SELECT 
                    concat(user.firstname, ' ', user.lastname) as full_name,
                    concat(approver.firstname, ' ',approver.lastname) as approver_name,
                    loan.* 
                    
                    FROM {$this->table} as loan 
                    LEFT JOIN users as user
                    ON user.id = loan.user_id 
                    
                    LEFT JOIN users as approver
                    ON approver.id = loan.approved_by
                    {$where} {$order}"
            );

            return $this->db->resultSet();
        }
    }