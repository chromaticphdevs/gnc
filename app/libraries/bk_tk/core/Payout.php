<?php namespace BKTK;

    use BKTK\Base;

    require_once __DIR__.'/Base.php';
    /**
     * Convert wallet to in-cashable money
     */

    class Payout extends Base
    {
        protected $controller = 'payout';
        /**
         * Convert user wallet to in-cashable money
         */
        public function single($userId)
        {
            if(!is_numeric($userId)) {
                $this->addError(" Invalid User Id");
                return false;
            }

            $response = $this->post('releaseByUser' , [
                'userId' => $userId
            ]);

            if(!$response->status) {
                $this->addError([
                    'single payout -error',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response->data;
        }


        public function multiple($userIds)
        {
            $isValid = true;

            foreach($userIds as $userId) 
            {
                if(!is_numeric($userId)){
                    $isValid = false;
                    break;
                }
            }

            if(!$isValid){
                $this->addError("Invalid Multiple payout");
                return false;
            }

            $response = $this->post('releaseByUsers' , $userIds);

            if(!$response->status) {
                $this->addError([
                    'multiple payout -error',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response->data;
        }
    }