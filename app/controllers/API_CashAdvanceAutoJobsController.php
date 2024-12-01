<?php

    use Services\CashAdvanceService;
    load(['CashAdvanceService'], APPROOT.DS.'services');

    /**
     * this controller
     * runs all things about cash advance processes
     */
    class API_CashAdvanceAutoJobsController extends Controller
    {
        public $serviceCashAdvance;
        
        public function __construct()
        {
            parent::__construct();
            $this->serviceCashAdvance = new CashAdvanceService();
        }

        /**
         * daily cutoff automated
         * procedures
         */
        public function dailyCutOff() {
            // _mail(['edromero1472@gmail.com', 'chromaticsoftwares@gmail.com'] , '(10:30 PM TO 11:59 PM)PENALY CUTOFF' , 'Daily cutoff penalize users RAN');
            $dateToday = date('h:i:s A');
            // $dateToday = date('h:i:s A', strtotime('10:50 PM'));

            $startCutoff =  strtotime('10:30 PM'); //this is lesser than 01:00am
            $endCutOff =  strtotime('11:59 PM'); //this is bigger than 12:00am
            $dateTodayInTime = strtotime($dateToday);
            /**
             * this will run every
             * 10:30 pm until 11:59 pm
             */
            $condition = ($dateTodayInTime >= $startCutoff) && ($dateTodayInTime <= $endCutOff);
            // $condition = true;
            
             if($condition) {
                // _unitTest(true, 'Daily cutoff penalize users Start');
                $payments = $this->serviceCashAdvance->penalizeNoDailyPayments();
                _unitTest(true, 'Daily cutoff penalize users');
             }
             
        }
    }