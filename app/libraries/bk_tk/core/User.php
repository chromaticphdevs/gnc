<?php namespace BKTK;

    use BKTK\Base;

    require_once __DIR__.'/Base.php';

    class User extends Base
    {

        public $controller = 'user';

        public function getAll()
        {
            $response =  $this->fetch('');
            
            if(!$response->status){
                $this->addError([
                    'Fetching users failed',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response->data;
        }

        public function getByToken($token)
        {
            $response =  $this->fetch('get' , [
                'token' => $token
            ]);

            if(!$response->status) {
                $this->addError([
                    'Get by token failed',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response->data;
        }

        public function getCompleteByToken($token)
        {
            $response =  $this->fetch('getComplete' , [
                'token' => $token
            ]);

            if(!$response->status) {
                $this->addError([
                    'GeT complete by token failed',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response->data;
        }

        /**
         * Data is the columns that will be updated
         * token is the userID
         */
        public function update($data , $token)
        {
            $postData = array_merge($data , [
                'userToken' => $token
            ]);

            $response = $this->post('update' , $postData);
            

            if(!$response->status) {
                $this->addError([
                    'Update failed',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response;
        }

        public function delete($token)
        {
            $response = $this->post('delete' , [
                'userToken' => $token
            ]);

            if(!$response->status) {
                $this->addError([
                    'Update failed',
                    'msg' => $response->data
                ]);
                return false;
            }

            return $response;
        }

    }