<?php 
    
    class LoanJobModel extends Base_model
    {
        public $table = 'loan_jobs';
        const DAILY_CUTOFF_PENALTY = 'DAILY_CUTOFF_PENALTY';

        /**
         * execute daily cutoff penalty
         */
        public function dailyCutoffPenalty() {  
            $cutoff = parent::dbget([
                'job_key' => self::DAILY_CUTOFF_PENALTY
            ]);
            $today = get_date(today());
            
            if(strtotime(get_date($cutoff->last_run)) < strtotime($today)) {
                //execute
                parent::dbupdate([
                    'last_run' => $today
                ], $cutoff->id);
                return true;
            } else {
                $this->addError("Last " . self::DAILY_CUTOFF_PENALTY . ' execution '. $today);
                return false;
            }
        }
    }