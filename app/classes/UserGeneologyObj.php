<?php   

    class UserGeneologyObj 
    {

        public function __construct($geneologyModel)
        {
            $this->userGeneologyModel = $geneologyModel;
        }

        public function getBaseOne($data)
        {   
            return [
                $this->userGeneologyModel->get_user($data[0]),
                $this->userGeneologyModel->get_user($data[1])
            ];
        }

        public function getBaseTwo($data)
        {
           return $this->instanciateData($data);
        }

        public function getBaseThree($data)
        {
            return $this->instanciateData($data);
        }

        public function getBaseFour($data)
        {
            return $this->instanciateData($data);
        }



        private function instanciateData($data) 
        {

            $returnData = [];/**Will return all downlines of the matrix */

            $dataSize = sizeof($data);/**Size of the data */

            $counter = 0; /**Counter */
            
            $position = 0; /**Position of fetch */

            while($counter!= $dataSize) 
            {
                /**first instance is zero and position is 0*/
                array_push($returnData , $this->userGeneologyModel->get_user($data[$counter]['downlines'][0]));
                array_push($returnData , $this->userGeneologyModel->get_user($data[$counter]['downlines'][1]));
                $counter++;               
            }

            return $returnData;
        }
        public function getBaseFive($data) 
        {
            return $this->instanciateData($data);
        }

        public function getBaseSix($data)
        {
            return $this->instanciateData($data);
        }

        public function getBaseSeven($data)
        {
            return $this->instanciateData($data);
        }

        public function getBaseEigth($data)
        {
            return $this->instanciateData($data);
        }

        public function getBaseNine($data)
        {
            return $this->instanciateData($data);
        }

        public function getBaseTen($data)
        {
            return $this->instanciateData($data);
        }

        public function getBaseEleven($data) {
            return $this->instanciateData($data);
        }

        public function getBaseTwelve($data) {
            return $this->instanciateData($data);
        }

        public function getBaseThirteen($data) {
            return $this->instanciateData($data);
        }

        public function getBaseFourteen($data) {
            return $this->instanciateData($data);
        }

    }