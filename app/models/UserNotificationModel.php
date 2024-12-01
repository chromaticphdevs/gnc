<?php

    class UserNotificationModel extends Base_model
    {
        public $table = 'user_notifications';

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }
            $this->db->query(
                "SELECT un.* FROM {$this->table} as un
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }
    }