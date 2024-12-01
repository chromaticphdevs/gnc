<?php 
    use Classes\Loan\BoxOfCoffee;
    use Classes\Loan\LoanService;

    require_once CLASSES.DS.'Loan/BoxOfCoffee.php';
    require_once CLASSES.DS.'Loan/LoanService.php';

    class API_Loan extends Controller
    {

        public function __construct()
        {
            $this->model = model('LoanModel');
        }

        public function getUserBalance($userId)
        {
            $result = $this->model->getUserBalance($userId);
            ee(api_response($result));
        }

        public function getBoxOfCoffeeCreditLimit($userId)
        {
            $result = $this->model->getUserCreditLimit($userId, LoanService::LOAN_TYPE_BOX_OF_COFFEE);
            ee(api_response($result));
        }
    }