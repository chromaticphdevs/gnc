<?php 

    class GlobalMetaModel extends Base_model
    {
        public $table = 'global_meta';

        public function save($storeData) {
            $ifExists = parent::dbget_single(parent::convertWhere($storeData));
            if(!$ifExists) {
                return parent::store($storeData);
            }
            return true;
        }
        
        public function all($params = []) {
            $where = empty($params['where'] ?? '') ? null : parent::convertWhere($params['where']);
            $order = $params['order'] ?? 'meta_value';
            return parent::dbget_desc($order, $where);
        }
    }