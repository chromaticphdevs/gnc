<?php 
    class CAQualifiedUserModel extends Base_model
    {
        public $table = 'ca_qualified_users';

        public function addQualified($userId) {
            _unitTest(true, "Adding user as qualified user {$userId}");
            $doesExist = parent::dbget_single(parent::convertWhere([
                'user_id' => $userId
            ]));

            if(!$doesExist) {
                return parent::store([
                    'user_id' => $userId,
                    'verified_date' => today()
                ]);
            } else {
                return true;
            }
        }
    }