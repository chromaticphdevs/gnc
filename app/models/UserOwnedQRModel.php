<?php 
    use Classes\Service\CommissionService;
    use Classes\Binary\Pair60Computation;
    require_once CLASSES.DS.'Binary/Pair60Computation.php';

    load(['CommissionService'], CLASSES);
    class UserOwnedQRModel extends Base_model
    {
        public $table = 'user_owned_qrs';
        public $retVal;

        public function __construct()
        {
            parent::__construct();

            $this->qr_code_model = model('UniversalCodeModel');
            $this->binaryModel = model('BinaryTransactionModel');
            $this->topUpModel = model('TopupModel');
            $this->binary = model('BinaryTransactionModel');
            $this->userModel = model('User_model');
            $this->pairCounter = model('BinaryPairCounterModel');
        }
        /**
         * collected values will be
         * direct_id , upline_id,
         * downline_position , qr_id
         */
        public function collect($params = [])
        {
            $code = $this->qr_code_model->dbget($params['qr_id']);

            if( $code->is_used ) {
                $this->addError("This code is not available for use.");
                return false;
            }
            //check first if code already used
            $collect_code_id = parent::store($params);
            $use_code = $this->qr_code_model->use_code( $params['qr_id'] );

            if( $collect_code_id && $use_code ) {
                $this->addMessage("Code used successfully.");
                return true;
            }

            $this->addError("Code Collection Error.");
            return false;
        }
        
        public function getAll($params = [])
        {
            $where = null;
            $order = null;
            if(isset($params['where'])) 
                $where = " WHERE " .$this->dbParamsToCondition($params['where']);

            if(isset($params['order']))
                $order = " ORDER BY {$params['order']}";

            $this->db->query(
                "SELECT uoq.*, 
                    CONCAT(direct.firstname , ' ' , direct.lastname) as direct_name,
                    direct.username as direct_username,
                    CONCAT(upline.firstname , ' ' , upline.lastname) as upline_name,
                    upline.username as upline_username,
                    uc.code as code
                    
                    FROM {$this->table} as uoq
                    LEFT JOIN users as direct
                    ON direct.id = uoq.direct_id

                    LEFT JOIN users as upline
                    ON upline.id = uoq.upline_id
                    
                    LEFT JOIN universal_codes as uc
                    ON uc.id = uoq.qr_id
                    {$where} {$order}"
            );

            return $this->db->resultSet();
        }

        public function get($id)
        {
            $owned_code = $this->getAll([
                'where' => [
                    'uoq.id' => $id
                ]
            ]);

            if($owned_code)
                return $owned_code[0];

            return false;
        }

        public function use($id, $used_by)
        {
            return parent::dbupdate([
                'is_used' => true,
                'used_by' => $used_by
            ] , $id );
        }
        
        public function topUp($id)
        {
            $addOnMessages = [];
            $qrCode = $this->get($id);

            if (!$qrCode) {
                $this->addError("QRcode does not exists");
            } else if ($qrCode->is_used){
                $this->addError("Code is already used");
            }

            if($this->getErrors())
                return false;

            //add point
            $res = $this->topUpModel->add([
                'point' => 1,
                'user_id' => $qrCode->user_id,
                'type'   => 'add'
            ]);

            if($res) {
                $this->use($qrCode->id, $qrCode->user_id);
                $totalBalance = $this->topUpModel->getBalance($qrCode->user_id);
                $user = $this->userModel->get_user($qrCode->user_id);

                if (isEqual($user->status, 'pre-activated') && $totalBalance >= Pair60Computation::PAIR_TRESHOLD) {
                    $this->userModel->updateStatus('reseller',$qrCode->user_id);
                }

                //add binary points to all upline
                if ($totalBalance >= $this->binary->pairing_treshold) {
                    $directSponspor = $this->userModel->user_get_sponsor($qrCode->user_id);
                    if($directSponspor) {
                        CommissionTransactionModel::make_commission($directSponspor->id, null, CommissionService::DIRECT_SPONSOR, 1000, 'BREAKTHROUGH');
                    }
                    //drc comission.
                    $uplines = get_user_uplines($qrCode->user_id);
                    
                    foreach ($uplines as $key => $row) {
                        $binaryRetval = $this->binary->add([
                            'userid'   => $row->id,
                            'point'     => 1,
                            'position'  => $row->user_position
                        ]);
                        if ($binaryRetval['AMOUNT'] > 0) {
                            $this->binary->addComission(...[
                                $row->id,
                                $binaryRetval['AMOUNT'],
                                $binaryRetval['DESCRIPTION'],
                                null
                            ]);
                            $addOnMessages[] = $binaryRetval['DESCRIPTION'];
                        }
                    }
                    
                    $res = $this->topUpModel->add([
                        'point' => $this->topUpModel::TRESHOLD,
                        'user_id' => $qrCode->user_id,
                        'type'   => 'minus'
                    ]);


                    //update user
                    $this->userModel->dbupdate([
                        'status' => 'starter'
                    ], $qrCode->user_id);
                }
            }

            if(!empty($addOnMessages)) {
                $this->addMessage(implode(',', $addOnMessages));  
            }
            return true;
        }

        /**
         * code_id,username
         */
        public function sendTo($param = [])
        {
            $user_model = model('User_model');

            $user = $user_model->get_by_username($param['username']);

            if(!$user) {
                $this->addError("user does not exists.");
                return false;
            }
            // user_owned_qrs
            return parent::dbupdate([
                'user_id' => $user->id,
                'direct_id' => $user->id,
                'upline_id' => $user->id
            ] , $param['user_code_id']);
        }

        public function sendToMultiple($param = []) {
            $qrCodes = $param['qr_codes'];
            $username = $param['username'];
            $qrCodes = unseal($qrCodes);

            foreach($qrCodes as $key => $row) {
              $isOkay = $this->sendTo([
                    'username' => $username,
                    'user_code_id' => $row
                ]);  

              if(!$isOkay) {
                return false;
              }
            }

            return true;
        }

        public function isOwnedByUser($user_id , $code_owner_id)
        {
            if($user_id != $code_owner_id)
                return false;
            return true;
        }
    }