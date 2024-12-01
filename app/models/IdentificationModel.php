<?php 

    class IdentificationModel extends Base_model
    {
        public $table = 'users_uploaded_id';

        public function getByUser($userId) {
            return parent::dbget_assoc('date_time', parent::convertWhere([
                'userid' => $userId
            ]));
        }
    }