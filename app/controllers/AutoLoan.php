<?php
  /*
  *Buy product with payment attached
  */
  class AutoLoan extends Controller
  {

    public $pathUpload = PUBLIC_ROOT.DS.'assets/payment_image/';

    public function __construct()
    {
      $this->userModel = $this->model('User_model');
      $this->code = $this->model('INCodelibraryModel');
      $this->branchInventory = $this->model('FNItemInventoryModel');
      $this->branch          = $this->model('FNBranchModel');
      $this->product = $this->model('INProductModel');
      /*
      *INVENTORY TRANSACTION MODEL
      */
      $this->fncodeInventory = $this->model('FNCodeInventoryModel');
      $this->fnproductBorrower = $this->model('FNProductBorrowerModel');
      $this->fnproductRelease = $this->model('FNProductReleaseModel');
      $this->fnproductReleasePayment = $this->model('FNProductReleasePaymentModel');
      $this->fncashInventory  = $this->model('FNCashInventoryModel');

      /*
      *COMMISSION TRANSACTION MODEL
      */
      $this->commission = $this->model('commissiontrigger_model');
      $this->payin     = $this->model('LDPayinModel');

    }


    public function get_product_borrower()
    {
      $branchid = $this->check_session();

      if($this->request() === 'POST')
      {
      }else{

        $data = [
                  'title' => "Product Borrower",
                  'result' => $this->fnproductBorrower->get_product_borrower($branchid)
              ];

              foreach ($data['result'] as $key => $value) {

                $this->make('17', '280', '1', '0', $value->userid);
              }
              //return request()->return();
      }

    }



    public function make($codeId, $amount, $quantity, $delivery_fee, $user_id )
    {  
   

      $messages = [];
      $errors   = [];

      if(Session::check('USERSESSION')) {
        $branchManager = $this->userModel->get_user(Session::get('USERSESSION')['id']);
        // $branchid = $branchManager->branchId;
        $branchid = '8'; //if admin automatic to 8
      }

      if(Session::check('BRANCH_MANAGERS')) {
        $branchManager = Session::get('BRANCH_MANAGERS');
        $branchid = $branchManager->branchid;
      }

      $stock_manager = 0;
      if(Session::check('BRANCH_MANAGERS'))
      {
        $user = Session::get('BRANCH_MANAGERS');
        $stock_manager = $user->id;

      }else if(Session::check('USERSESSION'))
      {
        $stock_manager = 1; //if admin automatic to userid 1
      }

 
      $purchaser = $this->userModel->get_user($user_id);

      if(empty($purchaser))
      {
        Flash::set("Error no Prurchaser Info" , 'danger');
        return request()->return();
      }

      /*
      *Code Library
      */
      $code = $this->code->dbget($codeId);
      /*
      * GET PRODUCT INFORMATION
      */
      $product = $this->product->dbget($code->product_id);
      /*
      *GET BRANCH INFORMATION
      */
      $branch = $this->branch->dbget($branchid);

      /*
      *CHECK FOR BRANCH STOCKS OF THE PRODUCT
      */
      $productStocks = $this->branchInventory->getProductStocksByBranch($code->product_id , $branchid);

      /**************************
      *** No stocks available ****
      *** Return To Previous page ***
      **************************/
      if(!$productStocks) {
        Flash::set("No stocks for product {$product->name}" , 'warning');
        return request()->return();
      }
  

      /********************************************
      *** INVENTORY TRANSACTIONS AND LOGGING ***
      ********************************************/

      /*set the transactions code
      *This code will be used to tracked down
      *Inventory transaction relation
      */
      $inventoryTransactionCode = $this->fnproductBorrower->make_code();

      $stockTransactions = [];

      if($purchaser->id == 0 )
      {
        Flash::set("Error no Prurchaser Id" , 'danger');
        return request()->return();
      }

      $stockTransactions['release'] = $this->fnproductRelease->store([
        'userid' => $purchaser->id,
        'code'   => $inventoryTransactionCode,
        'code_id' => $codeId,
        'amount' => $amount,
        'quantity' => $quantity,
        'branchid' => $branchid,
        'category' => 'product-loan',
        'stock_manager' =>  $stock_manager,
        'delivery_fee' => $delivery_fee,
        'product_name' => $product->name,
        'status'  => 'Approved'
      ]);


      $stockTransactions['inventory'] = $this->branchInventory->store([
        'branchid'    => $branchid,
        'quantity'    => ($quantity * -1),
        'description' => "Product release, Product Loan Number {$inventoryTransactionCode}",
        'product_id'  => $code->product_id
      ]);

      /**STORE ERROR LOGS OF STOCK TRANSACTIONS**/
      if(!$stockTransactions['release'])
        $errors[] = "Stock Transaction release failed";

      if(!$stockTransactions['inventory'])
        $errors[] = "Stock Transaction inventory failed";

      $redirect_link = "FNProductAdvance";
      if(isset($_POST['link']))
      {
        $redirect_link = $_POST['link'];
      }


      if(!empty($errors)) {
        Flash::set(implode(',' , $errors) , 'danger');
        return redirect($redirect_link);
      }

      /**
      *INFORMATION MESSAGE CONTAINS
      *ACCOUNTS UPGRADE MESSAGE OR OTHER STUFFS
      */
      if(!empty($message)){
        Flash::set(implode(',' , $message) , 'info' , 'purchase_message');
      }

      Flash::set("Product Advance Purchase with payment successful! Product : $code->name");
      return request()->return();
    


    }
    private function check_session()
    {

      if(Session::check('BRANCH_MANAGERS'))
      {
        $user = Session::get('BRANCH_MANAGERS');
        $branchid = $user->branchid;
        return $branchid;

      }else if(Session::check('USERSESSION'))
      {
        $branchid = 8;
        return $branchid;

      }else{
        redirect('user/login');
      }
    }

  }
