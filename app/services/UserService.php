<?php 
    namespace Services;

    class UserService{
        const EMAIL_UNVERIFIED = 'un-verified';
        const EMAIL_VERIFIED = 'verified';
        
        public static function getMetaKeys() {

            return array_merge(self::expensesKeys(), self::assets(), self::incomeKeys(), self::liabilities());
        }

        public static function numberKeys() {
            return array_merge(self::expensesKeys(), self::assets(), self::incomeKeys(), self::liabilities());
        }

        public static function expensesKeys() {
            return ['Daily food expenses no dependents',
            'Daily food expenses with dependents',
            'Monthly Home rentals/Ammortization',
            'Monthly Clothing Expenses',
            'Daily transportation/gas/diesel',
            'Tuition Fees',
            'Student allowances',
            'Utilities/Meralco/Communications ',
            'Misc. / other Expenses'];
        }

        public static function incomeKeys() {
            return ['Personal monthly income',
            'Employment Salary',
            'Sales Commision',
            'Other Source monthly',
            'Other income',
            'Rental income'];
        }

        public static function liabilities() {
            return [
                'Mortgage Loan',
                'Bank loans',
                'Personal Loans',
                'Other loans'
            ];
        }

        public static function assets() {
            return [
                'Vehicles',
                'House and lot',
                'Other Assets',
                'Savings',
                'Bank'
            ];
        }
    }