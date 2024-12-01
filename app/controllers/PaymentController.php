    <?php

use Classes\Loan\LoanService;

    load(['LoanService'],CLASSES.DS.'Loan');
    class PaymentController extends Controller
    {

        public function __construct()
        {
            $this->user_model = model('User_model');
            $this->loan = model('LoanModel');
        }

        public function pay($userId)
        {
            if (request()->isPost()) {
                $post = request()->inputs();

                $res = $this->loan->addPaymentWithLoanId($post);

                if(!$res){
                    Flash::set($this->loan->getErrorString(), 'danger');
                }else{
                    Flash::set($this->loan->getMessageString());
                }

                return redirect('PaymentController/pay/'.$post['user_id']);
            }

            $user = $this->user_model->get_user($userId);
            $loans = $this->loan->getAll([
                'where' => [
                    'loan.user_id' => $userId,
                    'entry_type'   => LoanService::ENTRY_TYPE_LOAN,
                    'loan.remaining_balance' => [
                        'condition' => '>',
                        'value' => 0
                    ]
                ]
            ]);
            
            $data = [
                'title' => 'Create Payment',
                'user'  => $user,
                'loans'  => $loans,
                'loanBalance' => $this->loan->getUserLoanBalance($userId)
            ];

            return $this->view('payment/create', $data);
        }
    }