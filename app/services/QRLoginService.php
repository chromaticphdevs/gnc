<?php
    namespace Services;

use function PHPSTORM_META\map;

    class QRLoginService {


        public function getGroups($defaultGroup = null) {
            /**
             * create mon-fri groups 2,4,6 time
             */
            $retVal = [];
            $days = [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ];
            $curdateCounter = 0;
            $curtimeCounter = 2;
            $loop = true;
            $id = 1;
            while($loop) {
                $currentDay = $days[$curdateCounter];
                $addTime = $curtimeCounter + 2;

                $scheduleTime = "({$currentDay}) {$curtimeCounter}:00 To {$addTime}:00";
                $curtimeCounter += 2;
                if($curtimeCounter >= 6) {
                    $curdateCounter++;
                    $curtimeCounter = 2;
                }

                $retVal[$id] = $scheduleTime;
                $id++;

                if(count($days) <= $curdateCounter) {
                    $loop = false;
                }
            }

            return is_null($defaultGroup) ? $retVal : $retVal[$defaultGroup] ?? 'N/A';
        }
    }