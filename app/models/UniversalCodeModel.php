<?php

    use Services\QRTokenService;
    load(['QRTokenService'], APPROOT.DS.'services');

    class UniversalCodeModel extends Base_model
    {
        const TYPE_RAFFLE = 'RAFFLE';
        const DEFAULT_PARENT_ID = 1;
        

        private $path =  PUBLIC_ROOT.DS.'public/qr_codes/';
        private $url_image_container  = URL.DS.'public/public/qr_codes/';
        public $table = 'universal_codes';

        
        public function __construct()
        {
            parent::__construct();
            require_once LIBS.DS.'phpqrcode'.DS.'qrlib.php';
            $this->batch_model = model('CodeBatchModel');
            
        }

        public function getAvailable()
        {
            $results = parent::dbget_assoc('id' , " is_used = false ");

            return $results;
        }

        /**
         * BATCH QUANTITY
         */
        public function createMultiple($batchQuantity , $attributes = [])
        {
            $code_ids = [];
            $quantity = $this->itemizedBatchQuantity($batchQuantity);

            if($quantity <= 0) {
                $this->addError("Quantity must greater than 0");
                return false;
            }

            for($i = 0 ; $i < $quantity ; $i++){
                $code_ids[] = $this->generate($attributes['description'], $attributes['code_type'] ?? self::TYPE_RAFFLE, $attributes['parent_id'] ?? self::DEFAULT_PARENT_ID);
            }

            $this->batch_model->createBatch($code_ids);

            return $code_ids;
        }

        public function createMultipleByQuantity($quantity,$attributes)
        {
            $code_ids = [];

            for ($i = 0; $i < $quantity; $i++) {
                $code_ids[] = $this->generate($attributes['description'] ?? 'CODE', $attributes['code_type'] ?? self::TYPE_RAFFLE, 
                    $attributes['parent_id'] ?? self::DEFAULT_PARENT_ID,
                    $attributes['batch_id'] ?? null);
            }
            $this->batch_model->createBatch($code_ids, $attributes['parent_id'] ?? self::DEFAULT_PARENT_ID);
        }

        public function generateRaffleCodeRegistration($description)
        {
            $url = URL.DS.'RaffleRegistrationController/register';
            return $this->generate($description, 'Raffle');
        }


        public function generate($description, $code_type = 'raffle', $parent_id = null, $batch_id = null)
        {
            $code = strtoupper(get_token_random_char(12));
            
            $qr = QRTokenService::createQRImage([
                'path' => PATH_UPLOAD.DS.'universal_codes',
                'code' => $code,
                'srcURL' => GET_PATH_UPLOAD.DS.'universal_codes'
            ]);

            $code_id = parent::store([
                'code' => $code,
                'description' => $description,
                'code_type' => $code_type,
                'parent_id' => $parent_id,
                'batch_id' => $batch_id,
                'image_full_path' => $qr['path'],
                'image_url' => $qr['srcURL'],
            ]);

            return $code_id;
        }

        public function use_code($code_id)
        {
            return parent::dbupdate([
                'is_used' => true
            ] , $code_id);
        }

        /**
         * Batch 1 = 9*8 = 72 codes
         */
        private function itemizedBatchQuantity($batch)
        {
            $codesPerSheet = 9*8;
            return ($codesPerSheet) * $batch;
        }

        public function getByCodeIds( $codeIds = [])
        {
            $this->db->query(
                "SELECT * FROM {$this->table}
                    WHERE id in('".implode("','" , $codeIds)."')
                    AND is_used != 1"
            );

            return $this->db->resultSet();
        }

        public function distributeCodes($username , $quantity, $batchId = null)
        {
            $this->user_qr_code_model = model('UserOwnedQRModel');
            $this->user_model = model('User_model');

            $results = parent::dbget_assoc('id', parent::convertWhere([
                'is_used' => false,
                'batch_id' => $batchId
            ]), $quantity);
            $user = $this->user_model->get_by_username($username);

            if( !$user) {
                $this->addError("No user found");
                return false;
            }
            $user_id = $user->id;

            $is_ok_upload = [];
            if($results) 
            {
                foreach($results as $key => $row) 
                {
                    // $is_ok = $this->use_code($row->id);
                    $is_ok_two = $this->user_qr_code_model->collect([
                        'direct_id' => $user_id,
                        'upline_id' => $user_id,
                        'user_id'   => $user_id,
                        'qr_id' => $row->id
                    ]);

                    $is_ok_upload[] = $is_ok_two;
                }
            }

            return $is_ok_two;
        }
    }
