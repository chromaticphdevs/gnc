<?php

    class TimelogModel extends Base_model
    {
        public $table = 'time_logs';
        const RATE_PER_HOUR = 50;

        public function __construct()
        {
            parent::__construct();
            $this->today = today();
        }

        public function getTimesheets($userId = null) {
            $WHERE = null;
            if (!is_null($userId)) {
                $WHERE = " WHERE timelog.user_id = '{$userId}' ";                
            }

            $this->db->query(
                "SELECT concat(user.firstname , ' ' ,user.lastname) as full_name,
                    timelog.* 
                    FROM {$this->table} as timelog 
                    LEFT JOIN users as user 
                    ON user.id = timelog.user_id
                    
                    {$WHERE}
                    ORDER BY timelog.id desc"
            );
            return $this->db->resultSet();
        }

        public function clockIn($userId) {
            $timelog = $this->getLast($userId);
            if ($this->isLoggedIn($timelog)) {
                $this->addError("You are already logged in.");
                return false;
            } else {
                //store
                $logId = parent::store([
                    'user_id' => $userId,
                    'clock_in_time' => $this->today,
                    'rate_per_hour' => self::RATE_PER_HOUR
                ]);
                $this->addMessage("Login-successfull");
                return $logId;
            }
        }

        public function clockOut($userId) {
            $timelog = $this->getLast($userId);
            if(!$this->isLoggedIn($timelog)) {
                $this->addError("No active login found");
                return false;
            }
            $durationInMinutes = timeDifferenceInMinutes($timelog->clock_in_time, $this->today);
            $totalAmount = (self::RATE_PER_HOUR/60) * $durationInMinutes;
            $isOk = parent::dbupdate([
                'clock_out_time' => $this->today,
                'duration_in_minutes' => $durationInMinutes,
                'total_amount' => $totalAmount
            ], $timelog->id);
            $this->addMessage("Logout -successfull");

            return $isOk;
        }

        public function getLast($userId) {
            $this->db->query(
                "SELECT * FROM {$this->table}
                    WHERE user_id = '{$userId}'
                    ORDER BY id desc "
            );
            return $this->db->single();
        }

        public function isLoggedIn($timelog) {
            if ($timelog) {
                if (is_null($timelog->clock_out_time)) {
                    return true;
                }
                return false;
            }
            return false;
        }
    }