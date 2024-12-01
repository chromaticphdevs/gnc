<?php 

    class FileStorageModel extends Base_model{
        public $table = 'file_storage';


        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(isset($params['where'])) {
                $where = " WHERE ".parent::convertWhere($params['where']);
            }

            if(isset($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            if(isset($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT *,
                    concat(file_url , '/' , file_name) as file_url_full, 
                    concat(file_path, '/' , file_name) as file_path_full
                    FROM {$this->table}
                    {$where} {$order} {$limit}"
            );
            return $this->db->resultSet();
        }

        public function get($id) {
            return $this->getAll([
                'where' => ['id' => $id]
            ])[0] ?? false;
        }

        public function single($parentId, $parentKey) {
            return $this->getAll([
                'where' => [
                    'parent_id' => $parentId,
                    'parent_key' => $parentKey
                ]
            ])[0] ?? false;
        }
    }