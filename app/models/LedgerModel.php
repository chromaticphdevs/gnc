<?php 

    class LedgerModel extends Base_model
    {
        public $table = 'accounts_ledger';
        public $_fillables = [
            'ledger_source',
            'ledger_source_id',
            'ledger_user_id',
            'ledger_entry_amount',
            'ledger_entry_type',
            'ledger_previous_balance',
            'ledger_ending_balance',
            'description',
            'entry_dt',
            'status',
            'created_by',
            'updated_by',
            'category',
        ];

        /**
         * use deduction ledger_entry_type for payent
         * for penalty and loan use addition
         */
        public function addLedgerEntry($ledger_source, $ledger_source_id, $ledger_user_id,
        $ledger_entry_amount, $ledger_entry_type, 
        $description, $entry_dt, $status, $created_by, $updated_by = null, $category = null
        ) {
            //default value is the entry
            $previous_balance = $ledger_entry_amount;
            $ending_balance = $ledger_entry_amount;
            //search if 
            $reference = $this->createReference(LEDGER_SOURCES['CASH_ADVANCE_LEDGER']);
            $latestRecord = $this->getLast([
                'where' => [
                    'ledger_source' => $ledger_source,
                    'ledger_source_id' => $ledger_source_id
                ]
            ]);
            
            // dump($latestRecord);

            $ledger_entry_amount_converted = ($ledger_entry_type == 'deduction') ? ($ledger_entry_amount * - 1) : $ledger_entry_amount;

            if($latestRecord) {
                $previous_balance = $latestRecord->ending_balance;
                $ending_balance = ($previous_balance + $ledger_entry_amount_converted);
            } else {
                $previous_balance = $ledger_entry_amount_converted;
                $ending_balance = $ledger_entry_amount_converted;
            }

            
            $data = [
                'ledger_reference' => $reference,
                'ledger_source' => $ledger_source,
                'ledger_source_id' => $ledger_source_id,
                'ledger_user_id' => $ledger_user_id,
                'ledger_entry_amount' => $ledger_entry_amount_converted,
                'ledger_entry_type' => $ledger_entry_type,
                'previous_balance' => $previous_balance,
                'ending_balance' => $ending_balance,
                'description' => $description,
                'entry_dt' => $entry_dt,
                'status' => $status,
                'created_by' => $created_by,
                'updated_by' => $updated_by,
                'category'   => $category
            ];
            
            return parent::store($data);
        }

        public function getLast($params = []) {
            $params['order'] = " aledger.id desc ";
            return $this->getAll($params)[0] ?? false;
        }
        public function getAll($params = []) 
        {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE " . parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT aledger.*,concat(user.firstname, ' ', user.lastname) as owner_full_name,
                user.firstname, user.lastname
                FROM {$this->table} as aledger
                    LEFT JOIN users as user 
                        ON user.id = aledger.ledger_user_id
                    {$where} {$order} {$limit}
                "
            );
            return $this->db->resultSet();
        }
        
        private function createReference($referenceType) {
            if($referenceType == LEDGER_SOURCES['CASH_ADVANCE_LEDGER']) {
                $prefix = '02';
            } else {
                $prefix = '88';
            }

            return strtoupper($prefix.get_token_random_char(10));
        }
    }