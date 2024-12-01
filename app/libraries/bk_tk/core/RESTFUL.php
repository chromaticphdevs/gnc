<?php   
    namespace BKTK;

    abstract class RESTFUL
    {
        

        public function post($action , $parameter  = [])
        {
            $fullEndPoint = $this->makeFullEndpoint($this->endpoint.'/api/'.$this->controller.'/'.$action);
            
            $response =  $this->apiPOST($fullEndPoint , $parameter);

            return $this->unwrapResponse($response);
        }

        public function postRaw($fullEndpoint = null , $parameter = [])
        {
            $fullEndPoint = $this->makeFullEndpoint($this->endpoint.'/api/'.$fullEndpoint);
            
            $response =  $this->apiPOST($fullEndPoint , $parameter);

            return $this->unwrapResponse($response);
        }

        public function apiPOST($url , $data)
        {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            // Optional Authentication:
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "username:password");

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }


        private function unwrapResponse($result)
        {
            return \json_decode($result);
        }
    }