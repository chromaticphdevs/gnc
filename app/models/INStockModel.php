<?php   

    class INStockModel extends Base_model 
    {
        public $table = 'in_stocks';

        /**
         * Join stocks on products
         * and branches
         */
        public function getAll($WHERE = null , $ORDER  = null , $LIMIT = null)
        {
            $this->db->query(
                "SELECT s.* , p.name as p_name , b.name as b_name 
                    FROM $this->table as s 
                    LEFT JOIN in_products as p
                        ON s.product_id = p.id 
                    LEFT JOIN fn_branches as b
                        ON s.branch_id = b.id
                    
                    $WHERE $ORDER $LIMIT"
            );

            return $this->db->resultSet();
        }

        public function get_list_desc($field)
        {
            $ORDER = " ORDER bY $field desc";

            $this->db->query(
                "SELECT s.* , p.name as p_name , b.name as b_name 
                    FROM $this->table as s 
                    LEFT JOIN in_products as p
                        ON s.product_id = p.id 
                    LEFT JOIN fn_branches as b
                        ON s.branch_id = b.id
                        $ORDER"
            );

            return $this->db->resultSet();
        }

        public function getLogs($WHERE) 
        {
            return $this->getAll( $WHERE , " order by id desc ");
        }

        /**
         * Get Summary of product stocks
         * on specified branch
         */
        public function getSummary($WHERE)
        {
            $this->db->query(
                " SELECT p.id as p_id , p.name as name , sum(s.quantity) as total_stock
                    FROM $this->table as s 
                    LEFT JOIN in_products as p 
                        ON p.id = s.product_id 
                    $WHERE 
                    GROUP BY s.product_id"
            );

            return $this->db->resultSet();
        }
    }