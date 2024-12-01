<?php

    class FNCashAdvanceAttributeModel extends Base_model
    {
        public $table = 'fn_cash_advances_attributes';

        public function addNew($attrData, $fnCAId) {
            if(!empty($attrData['borrowers'])) {
                $id = parent::store([
                    'fn_ca_id' => $fnCAId,
                    'attribute_key'    => 'BORROWER_KEY',
                    'attribute_value'  => seal($attrData['borrowers']),
                    'attribute_label'  => 'Co Borrower Data'
                ]);
            }
            return true;
        }

        public function getBorrowers($fnCAId) {
            $result = parent::dbget_single(parent::convertWhere([
                'fn_ca_id' => $fnCAId
            ]));
            
            if($result) {
                $result->attribute_value = unseal($result->attribute_value);
            }

            return $result;
        }
    }