<?php

    class UserCallModel extends Base_model

    {

        public $table = 'user_on_call';

        



        public function getStatus($userId)
        {
            return $this->dbHelper->single(...[

                $this->table,

                '*',

                " user_id = '$userId' "

            ]);

        }



        public function getCustomer($handlerId)

        {

            return $this->dbHelper->single(...[

                $this->table,

                '*',

                " handled_by = '$handlerId' "

            ]);

        }



        public function call($userId , $handleBy)

        {

            $today = today();



            $isExists = $this->dbHelper->single(...[

                $this->table,

                '*',

                " user_id = '{$userId}' "

            ]);



            if($isExists) 

            {

                $timeDifferenceInMinutes = timeDifferenceInMinutes( $isExists->created_at , 

                    $today);



                $differenceInHours = $timeDifferenceInMinutes / 60;



                if($differenceInHours > 24) 

                {

                    $this->getAndDropCall( $userId  , $handleBy , 'admin');



                    parent::store([

                        'user_id' => $userId,

                        'handled_by' => $handleBy,

                        'created_at' => $today

                    ]);

                    return true;

                }else{

                    $this->error = 'User already on call';

                    return false;

                }

            }else{

                parent::store([

                    'user_id' => $userId,

                    'handled_by' => $handleBy,

                    'created_at' => $today

                ]);

                return true;

            }

        }



        public function getAndDropCall($userId , $handleBy , $accountType)

        {

            $isCallDroped = $this->dropCall($userId , $handleBy , $accountType);



            if(!$isCallDroped) {

                return false;

            }



            return $this->callSession;

        }





        /*

        *Call Data Params

        *@customerId , screenTimeInMinutes,

        *account_type

        */

        private function saveTimeSheet($call , $callData = [])

        {

            $timesheetModel = model('CSR_TimesheetModel');



            $punchTime = strtotime(today());

            $callStartTime = strtotime($call->created_at);



            $timeDifferenceInSeconds = abs($punchTime - $callStartTime);



            //invalid 5 seconds call

            if($timeDifferenceInSeconds <= 2){

               $this->error = "Invalid call timesheet not saved!";

                return;

            }



            $screenTimeInMinutes = $timeDifferenceInSeconds / 60;

            

            if( $screenTimeInMinutes >= 5 ) 

                $screenTimeInMinutes = 5; // 5 mins is the max call







            return $timesheetModel->save(... [

                $callData['callerId'],

                $callData['customerId'],

                $screenTimeInMinutes,

                $callData['accountType']

            ]);

        }



        public function dropCall($userId , $handleBy , $accountType)

        {   

            $today = today();



            $callSession = $this->dbHelper->single(...[

                $this->table,

                '*',

                " user_id = '{$userId}' and handled_by = '{$handleBy}' "

            ]);

            

            if($callSession)

            {

                $this->callSession = $callSession;



                $res = $this->saveTimeSheet( $callSession , [

                    'customerId' => $userId,

                    'callerId' => $handleBy,

                    'accountType' => $accountType

                ]);





                $this->timesheetOk = $res;



                $condition = $this->dbParamsToCondition([

                    'id' => $callSession->id

                ]);



                return $this->dbHelper->delete($this->table , $condition);

            }

                

            $this->error = "Walang call session";



            return false;

        }



    }