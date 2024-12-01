<?php 
    class UserCreditLineModel extends Base_model {
        public $table = 'user_credit_line';

        public function getUserCreditLine($userId) {
            return parent::dbget_single(parent::convertWhere([
                'user_id' => $userId
            ]));
        }

        public function addUserCreditLine($userId, $creditLine) {
            return parent::store([
                'user_id' => $userId,
                'current_credit_line' => $creditLine
            ]);
        }
    }