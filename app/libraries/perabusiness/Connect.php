<?php   
    namespace Business;

    use Business\Core;

    require_once __DIR__.'/Core.php';
    class Connect extends Core
    {

        protected function authenticate( $key , $secret )
        {
            $payload = [
                'key' => $this->cleanAuth($key),
                'secret' => $this->cleanAuth($secret)
            ];
            //check connection
            $response = $this->restPostCall(
                'api/businessAccount/authenticate' , $payload
            );

            $status = $response->status;

            //something wentwrong
            if( !$status )
            {
                $responseData = $response->data;

                if( is_string($responseData) ){
                    $this->addError( $responseData );
                    return false;
                }

                if( is_array($responseData) ){
                    $this->addError( implode(',' , $responseData));
                    return false;
                }

                $this->addError( "Something went wrong !");

                return false;
            }

            return true;
        }

        private function cleanAuth( $str )
        {
            return trim( str_escape( $str ) );
        }
        
    }