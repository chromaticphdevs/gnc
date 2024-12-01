<?php   
    
    class INStock extends Controller
    {

        public function __construct()
        {
            $this->fnbranch = $this->model('FNBranchModel');
            $this->itemInventory = $this->model('FNItemInventoryModel');
        }
        public function index()
        {
            $data = [
                'branches' => $this->fnbranch->get_list_asc('name'),
                'stockMovements'    => $this->itemInventory->getListDecreaseWithLimit(100)
            ];

            return $this->view('inventory/stock/index' , $data);
        }
    }