<?php   
    namespace BKTK;
    
    use BKTK\RESTFUL;

    require_once __DIR__.'/RESTFUL.php';

    class Base extends RESTFUL
    {
        protected $endpoint = 'https://app.breakthrough-e.com';

        protected $fullEndPoint;

        protected $errors = [];
        /**
         * 
         */
        protected function fetch($action , $parameter  = [])
        {
            $returnData = false;

            $fullEndPoint = $this->makeFullEndpoint($this->endpoint.'/api/'.$this->controller.'/'.
                                                    $action.$this->stringifyParam($parameter));
            $timeSheets = file_get_contents($fullEndPoint);

            /**
             * IF Request returned something
             */
            if($timeSheets) 
                $returnData = \json_decode($timeSheets);

            return $returnData;
        }

        protected function fethRaw($fullEndpoint = null , $parameter = [])
        {
            $returnData = false;

            $fullEndPoint = $this->makeFullEndpoint($this->endpoint.'/ap/i'.$fullEndpoint.
                                                    $this->stringifyParam($parameter));

            $timeSheets = file_get_contents($fullEndPoint);
            
            /**
             * IF Request returned something
             */
            if($timeSheets) 
                $returnData = \json_decode($timeSheets);

            return $returnData;
        }

        protected function stringifyParam($param = null)
        {
            //check if param is either empty or null
            if(is_null($param) || empty($param))
                return '';

            $stringParam = '';

            if(!is_array($param)){
                $stringParam = '?'.$param;
            }

            if(is_array($param)) 
            {
                $iteration = 0;

                foreach($param as $paramKey => $row) 
                {
                    if($iteration == 0) 
                        $stringParam .= '?';
                    
                    if($iteration > 0)
                        $stringParam .= '&';

                    $stringParam .= "{$paramKey}={$row}";

                    $iteration++;
                }
            }

            return $stringParam;
        }

        public function makeFullEndpoint($fullEndPoint)
        {
            $this->fullEndPoint = $fullEndPoint;

            return $this->fullEndPoint;
        }

        public function getFulLEndpoint()
        {
            return $this->fullEndPoint;
        }

        public function addError($error)
        {
            $this->errors [] = $error;
        }

        public function getErrors()
        {
            return $this->errors;
        }

        public function getError()
        {
            return end($this->errors);
        }

        public function getErrorString()
        {
            return implode(',' , $this->getErrors());
        }
    }
?>