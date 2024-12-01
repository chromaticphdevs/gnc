<?php
    use CLasses\Inventory\InventoryService;
    use Classes\Loan\LoanService;

    load(['InventoryService'],CLASSES.DS.'Inventory');
    load(['LoanService'],CLASSES.DS.'Loan');

    class InventoryModel extends Base_model
    {
        public $table = 'inventories';
        public $table_name = 'inventories';
        
        private $_fillables = [
            'warehouse_id',
            'movement',
            'price_per_item',
            'item_type',
            'reference',
            'quantity',
            'date_of_entry'
        ];

        public function __construct()
        {
            parent::__construct();

            $this->codeModel = model('UniversalCodeModel');
        }

        public function save($inventoryData)
        {
            if (isEqual($inventoryData['movement'], InventoryService::MOVEMENT_DEDUCT)) {
                $inventoryData['price_per_item'] = $inventoryData['price_per_item'] * -1;
                $inventoryData['quantity'] = $inventoryData['quantity'] * -1;
            }
            $saveData = [];
            $inventoryData['reference'] = $this->generateReference();

            foreach($this->_fillables as $key => $row) {
                if(isset($inventoryData[$row])) {
                    $saveData[$row] = $inventoryData[$row]; 
                }
            }
            $saveData['date_of_entry'] = today();

            return parent::store($saveData);
        }


        public function distributeBoxOfCoffee($inventoryData)
        {
            $inventoryData['item_type'] = LoanService::LOAN_TYPE_BOX_OF_COFFEE;
            $batchId = $this->save($inventoryData);

            if (isEqual($inventoryData['movement'], InventoryService::MOVEMENT_ADD)) {

                $this->codeModel->createMultipleByQuantity($inventoryData['quantity'], [
                    'parent_id' => $inventoryData['warehouse_id'],
                    'description' => 'BOX OF COFFEE DISTRIBUTION',
                    'code_type'  => LoanService::LOAN_TYPE_BOX_OF_COFFEE,
                    'batch_id' => $batchId
                ]);
            }
            return $batchId;
        }

        private function generateReference()
        {
            return 'REF-'.random_number(12);
        }
    }