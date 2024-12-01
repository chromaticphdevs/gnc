<?php 

    class CodeBatchController extends Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->model = model('CodeBatchModel');
            $this->universal_code_model = model('UniversalCodeModel');
            $this->user_qr_code_model = model('UserOwnedQRModel');
        }

        public function index()
        {
            $data = [
                'batches' => $this->model->dbget_desc('id'),
                'title'   => 'Code Batch'
            ];

            return $this->view('code_batch/index' , $data);
        }

        private function getCodesByBatch($batch_code)
        {
            $retVal = [
                'batch' => null,
                'codes' => []
            ];
            $batch = $this->model->dbget_single(
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

        public function show( $batch_code )
        {   
            if( isEqual($this->request() , 'post') )
            {   
                $input  = request()->inputs();

                $res = $this->universal_code_model->distributeCodes($input['username'], $input['quantity'], $input['batch_id']);
                if(!$res) {
                    Flash::set( $this->universal_code_model->getErrorString() , 'danger');
                }else{
                    Flash::set("Code sent to user");
                }
            }

            $batchAndCodes = $this->model->getCodesByBatch($batch_code );
            $batch = $batchAndCodes['batch'];
            $codes = $batchAndCodes['codes'];
            $data = [
                'title' => 'Code Batch',
                'batch' => $batch,
                'codes' => $codes
            ];

            return $this->view('code_batch/show' , $data);
        }

        public function print($batch_code)
        {
            $batchAndCodes = $this->model->getCodesByBatch($batch_code );

            $batch = $batchAndCodes['batch'];
            $codes = $batchAndCodes['codes'];

            if(!is_null($batch)){ 

                if( isEqual($batch->status , 'printed') ) {
                    Flash::set("Unable to re-print this batch" , 'danger');
                    return request()->return();
                }
                $this->model->setBatchToPrint($batch->id);
            }
            $data = [
                'title' => 'Code Batch',
                'batch' => $batch,
                'codes' => $codes
            ];
            return $this->view('code_batch/print' , $data);
        }
    }