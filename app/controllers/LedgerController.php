<?php 

    class LedgerController extends Controller
    {
        public $model, $cashAdvanceModel, $cashAdvancePaymentModel;

        public function __construct()
        {
            parent::__construct();
            $this->model = model('LedgerModel');
            $this->cashAdvanceModel = model('FNCashAdvanceModel');
            $this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
        }

        public function index() {
            
        }

        public function showCashAdvance($cash_advance_id) {
            $cash_advance_id = unseal($cash_advance_id);
            $cash_advance = $this->cashAdvanceModel->getLoan($cash_advance_id);
            $payments = $this->cashAdvancePaymentModel->getAll([
                'where' => [
                    'ca_id' => $cash_advance_id
                ]
            ]);

            $ledgerList = $this->model->getAll([
                'where' => [
                    'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
                    'ledger_source_id' => $cash_advance_id
                ],
                'order' => 'aledger.id desc'
            ]);
            $endingBalance = $ledgerList[0]->ending_balance ?? 0;
            $data = [
                'ledger_list' => $this->model->getAll([
                    'where' => [
                        'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
                        'ledger_source_id' => $cash_advance_id
                    ],
                    'order' => 'aledger.id desc'
                ]),
                'payments' => $payments,
                'cash_advance' => $cash_advance,
                'id' => $cash_advance_id,
                'ending_balance' => $endingBalance
            ];

            return $this->view('ledger/cash_advance', $data);
        }

        public function ledger() {

        }
    }