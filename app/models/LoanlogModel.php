<?php

use Mpdf\Mpdf;

    class LoanlogModel extends Base_model {
        public $table = 'loan_logs';
        
        public $_fillables = [
            'loan_id',
            'user_id',
            'entry_type',
            'amount',
            'loan_attribute',
            'penalty_date',
            'remarks'
        ];

        public function addNew($params = []) {
            $_fillables = parent::getFillables($params);
            $responseId = parent::store($_fillables);

            return $responseId;
        }

        public function addNonPaymentPenalty($loan, $penaltyDate, $penaltyAmount) {

            $resp = $this->addNew([
                'loan_id' => $loan->ca_id,
                'user_id' => $loan->ca_userid,
                'entry_type' => '',
                'amount' => $penaltyAmount,
                'penalty_date' => $penaltyDate,
                'entry_type' => 'PENALTY',
                'loan_attribute' => LOAN_ATTRIBUTES['ATTORNEES_FEE_ABBR'],
                'remarks' => "Because of no recorded payment on {$penaltyDate} 
                    You are charged of PHP ($penaltyAmount) ". LOAN_ATTRIBUTES['ATTORNEES_FEE']
            ]);

            return $resp;
        }

        public function getAll($condition = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($condition['where'])) {
                $where = " WHERE ". parent::convertWhere($condition['where']);
            }

            if(!empty($condition['order'])) {
                $order = " ORDER BY {$condition['order']} ";
            }

            if(!empty($condition['limit'])) {
                $limit = " LIMIT {$condition['limit']} ";
            }
            $this->db->query(
                "SELECT loan_log.*,
                    concat(user.firstname,' ',user.lastname) as borrower_fullname,
                    fca.code as loan_reference ,
                    cdr.release_reference as release_reference,
                    cdr.id as release_id

                    FROM {$this->table} as loan_log
                    LEFT JOIN fn_cash_advances as fca
                        ON fca.id = loan_log.loan_id
                    LEFT JOIN cash_advance_releases as cdr
                        ON cdr.ca_id = loan_log.loan_id
                    LEFT JOIN users as user 
                        ON user.id = loan_log.user_id

                    {$where} {$order} {$limit}
                "
            );

            return $this->db->resultSet();
        }

        public function getLoanPenalties($loanId) {
            $totalAmount = 0;

            $loanPenalties = $this->getAll([
                'where' => [
                    'fca.id' => $loanId
                ],
                'order' => 'loan_log.id desc'
            ]);

            foreach($loanPenalties as $key => $row) {
                $totalAmount += $row->amount;
            }

            return [
                'totalAmount' => $totalAmount,
                'penalties' => $loanPenalties
            ];
        }
    }