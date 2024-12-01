<?php 

    class BinaryPairCounterModel extends Base_model
    {
        public $table = 'binary_pair_counter';
        /**
         * point can be negative
         */
        public function add($userId) {
            $total = $this->getTotal($userId);
            return parent::store([
                'user_id' => $userId,
                'point_prev' => $total,
                'point_entry' => 1,
                'point_total' => $total + 1
            ]);
        }

        public function clear($userId) {
            $total = $this->getTotal($userId);
            parent::store([
                'user_id' => $userId,
                'point_prev' => $total,
                'point_entry' => -3,
                'point_total' => 0
            ]);
        }

        public function getTotal($userId) {
            $this->db->query(
                "SELECT * FROM {$this->table}
                    WHERE user_id = '{$userId}'
                    ORDER BY id desc"
            );

            return $this->db->single()->point_total ?? 0;
        }
    }