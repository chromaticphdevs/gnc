<?php 
    namespace Business;
    
    class Core 
    {
        // protected $domain = 'http://dev.pera';
        protected $domain = 'https://pera-e.com';

        protected $errors = [];

        protected $warnings = [];

        protected $messages = [];
        /**
         * REST CALL
         */

        final protected function restCall($method, $url, $data = false)
        {
            $url = $this->domain . '/' . $url;

            $curl = curl_init();

            switch (strtoupper($method))
            {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);

                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_PUT, 1);
                    break;
                default:
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
            }

            // Optional Authentication:
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "username:password");

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);

            $response = trim($result);

            $response = json_decode($response);

            return $response;

            curl_close($curl);
        }

        final protected function restPostCall( $url , $data )
        {
            return $this->restCall('POST' , $url , $data);
        }
        

        /**
         * Messages
         */
        final public function addMessage($message)
        {
            $this->messages [] = $message;
        }

        final public function getMessages()
        {
            return $this->messages;
        }

        final public function getMessageString()
        {   
            if( !empty($this->messages))
                return implode(',' , $this->messages);

            return '';
        }
        /**
         * end messages
         */


        final public function addWarning($warning)
        {
            $this->warnings [] = $warning;
        }

        final public function getWarnings()
        {
            return $this->warnings;
        }

        final public function getWarningString()
        {   
            if( !empty($this->warnings))
                return implode(',' , $this->warnings);

            return '';
        }

        //returns array
        final public function addError($error)
        {
            $this->errors [] = $error;
        }

        //returns array
        final public function getErrors()
        {
            return $this->errors;
        }

        //returns string
        final public function getErrorString()
        {
            if(!empty($this->errors))
                return implode(',' , $this->errors);
            return '';
        }

        
    }