<?php
    use Services\UserService;
    load(['UserService'], APPROOT.DS.'services');

    class FinancialStatementController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->userMeta = model('UsermetaModel');
            $this->whoIs = whoIs();
            $this->userService = new UserService;
        }

        public function index() {

            $data = [
                'userMeta' => $this->userMeta->getByUser($this->whoIs['id']),
                'userService' => $this->userService,
            ];
            
            return $this->view('financial_statement/index', $data);
        }
    }