<?php 

    class TopupModel extends Base_model
    {
        public $table = 'topup_points';
        public static $TYPE_MINUS = 'minus';
        public static $TYPE_ADD = 'add';
        //change implementration
        const TRESHOLD = 1020;

        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Acceptable parameter key data
         * point,user_id,type[minus,add]
         */
        public function add($data)
        {
            $current_balance = $this->getBalance($data['user_id']);
            $insertData = [
                'user_id' => $data['user_id'],
                'minus_point'   => null,
                'add_point'     => null,
                'balance_point' => '',
                'description'   => ''
            ];
            /**
             * Arrange data
             */

            if(isEqual($data['type'], 'minus')) {
                $insertData['minus_point'] = $data['point'];
                $insertData['balance_point'] = $current_balance - $data['point'];
            } else {
                $insertData['add_point'] = $data['point'];
                $insertData['balance_point'] = $current_balance + $data['point'];
            }
            return parent::store($insertData);
        }

        public function getBalance($user_id)
        {
            $this->db->query(
                "SELECT ifnull(balance_point, 0) as balance 
                    FROM {$this->table}
                    WHERE user_id = '{$user_id}'
                    ORDER BY id desc"
            );
            return $this->db->single()->balance ?? 0;
        }

        //un-used
        private function convertTopupToBinary($balance_point = 0, $user_id)
        {
            //treshhold 60
            if($balance_point >= self::TRESHOLD) {
                $this->commission = model('Commissiontrigger_model');
                //add binary commission
                $this->commission->add_binary_points($user_id);
                //deduct 
                
                //update account
                $this->db->query("UPDATE users set status = 'starter' WHERE id = '{$user_id}' ");
                $this->db->execute();

                $this->db->query(
                    "SELECT * FROM users where id = '{$user_id}'"
                );

                $res = $this->db->single();

                $user_session = [
                    'id' => $res->id ,
                    'type' => $res->user_type,
                    'selfie' => $res->selfie,
                    'firstname' => $res->firstname,
                    'lastname'  => $res->lastname,
                    'username'  => $res->username,
                    'status'    => $res->status,
                    'is_activated' => $res->is_activated,
                    'branchId'    => $res->branchId,
                    'account_tag' => $res->account_tag,
                    'is_staff' => $res->is_staff
                ];
                
                Session::set('USER_INFO' , $res);
                Cookie::set('USERSESSION' , $user_session);
                Session::set('USERSESSION' , $user_session);
  
                return $this->add([
                    'point' => self::TRESHOLD,
                    'user_id' => $user_id,
                    'type' => 'minus',
                    'stop' => true
                ]);
            } 
        }
    }