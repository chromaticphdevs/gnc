<?php 

    class PettyCashUserModel extends Base_model
    {
        public $table = 'petty_cash_user';

        public function getAll($params = []) {

            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY ".$params['order'];
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT ".$params['limit'];
            }

            $this->db->query(
                "SELECT pcu.*,concat(user.firstname, ' ',user.lastname) as fullname
                    FROM {$this->table} as pcu
                    LEFT JOIN users as user
                    ON user.id = pcu.user_id
                    {$where}{$order}{$limit}"
            );

            return $this->db->resultSet();
        }

        public function getCurrent($userId) {
            return parent::dbget_single('user_id = '.$userId);
        }
    }