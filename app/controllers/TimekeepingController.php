<?php

    class TimekeepingController extends Controller
    {
        public function __construct()
        {
            $this->timelogModel = model('TimelogModel');
            $this->whoIs = whoIs();
        }

        public function index($userId = null) 
        {
            $data = [];
            $viewType = 'admin';
            
            if (isEqual(whoIs('type'), [USER_TYPES['MEMBER'], USER_TYPES['ENCODER_A']])) {
                $viewType = 'user';
                $log = $this->timelogModel->getLast($this->whoIs['id']);
                $timesheets = $this->timelogModel->getTimesheets($this->whoIs['id']);
                
                $data['log'] = $log;
                $data['isLoggedIn'] = $this->timelogModel->isLoggedIn($log);
            } else {
                $timesheets = $this->timelogModel->getTimesheets();
            }
            $data['viewType'] = $viewType;
            $data['timesheets'] = $timesheets;

            return $this->view('timekeeping/v2/index', $data);
        }

        public function clockIn() {
            $this->timelogModel->clockIn($this->whoIs['id']);
            Flash::set($this->timelogModel->getMessageString());
            return request()->return();
        }

        public function clockOut() {
            $this->timelogModel->clockOut($this->whoIs['id']);
            Flash::set($this->timelogModel->getMessageString());
            return request()->return();
        }
    }