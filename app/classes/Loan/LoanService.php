<?php 
    namespace Classes\Loan;

    class LoanService
    {
        const LOAN_TYPE_BOX_OF_COFFEE = 'BOX_OF_COFFEE';

        const LIMIT_TYPE_ITEM = 'NUMBER_OF_ITEMS';
        const LIMIT_TYPE_CASH = 'CASH_AMOUNT';

        const ENTRY_TYPE_LOAN = 'LOAN';
        const ENTRY_TYPE_PAYMENT = 'PAYMENT';

        const BOX_OF_COFEE_PRICE = 170.00;

        const CASH_ADVANCE = 'CASH_ADVANCE';

        const BRANCHES = [
            1 => 'BRANCH - A',
            2 => 'BRANCH - B',
            3 => 'BRANCH - C'
        ];
    }