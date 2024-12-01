<?php

    class CodeBatchModel extends Base_model
    {
        public $table = 'code_batches';

        public function createBatch($codes = [], $branchId)
        {
            if( empty($codes) ) {
                $this->addError("Codes are empty.");
                return false;
            }

            $res = parent::store([
                'batch_code' => $this->createCode(),
                'code_ids'   => json_encode($codes),
                'code_length' => count($codes),
                'branch_id'  => $branchId
            ]);

            if($res) {
                $this->addMessage("Batch Created!");
                return true;
            }
            $this->addError("Batch unable to create.");
            return false;
        }

        private function createCode()
        {
            return get_token_random_char(12);
        }

        public function setBatchToPrint($batch_id)
        {
            $dateTime = date('Y-m-d h:i:s a');

            return parent::dbupdate([
                'printed_date' => $dateTime,
                'status' => 'printed'
            ] , $batch_id);
        }

        public function getCodesByBatch($batch_code)
        {
            $this->universal_code_model = model('UniversalCodeModel');
            $retVal = [
                'batch' => null,
                'codes' => []
            ];
            $batch = parent::dbget_single(
                " batch_code = '{$batch_code}' "
            );

            if(!$batch)
                return $retVal;

            $codes = $this->universal_code_model->getByCodeIds(
                json_decode($batch->code_ids)
            );

            $retVal = [ 
                'batch' => $batch,
                'codes' => $codes
            ];

            return $retVal;
        }
    }