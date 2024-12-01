<?php
  /*
  *Buy product with payment attached
  */
  class FNProductAdvance extends Controller
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

    public function index()
    {
      /*SEARCH USER*/

      return $this->view('product_advance/search_user');
    }

    /*
    *GET REQUEST
    */
    public function create()
    {
        $data = [];

        /*
        *check if a user is not set
        */
        if(!isset($_GET['user_id'])) {
          Flash::set("Invalid Request, a user must be set" , 'danger');
          return redirect('FNProductAdvance/');
        }


        /*
        *Check if user is set
        *then view is create purchase
        */
        $user_id = $_GET['user_id'];

        $user = $this->userModel->get_user($user_id);

        $mainForm = 'formPurchaseAndPay';

        $data = [
          'userInfo' => $user ,
          'codes' => $this->code->dbget_assoc('name'),
          'input' => [
            'required' => [
              'form' => $mainForm,
              'class' => 'form-control',
              'required' => ''
            ],

            'form' => $mainForm
          ]
        ];

        return $this->view('product_advance/create' , $data);
    }

    public function make()
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

      $post = request()->inputs();

      $codeId           = $post['code_id'];
      $amount           = $post['amount'];
      $quantity         = $post['quantity'];
      $delivery_fee     = $post['delivery_fee'];
      $user_id          = $post['user_id'];

      /*
      *purchaser information
      */
      $purchaser = $this->userModel->get_user($user_id);
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

    
      if(!empty($errors)) {
        Flash::set(implode(',' , $errors) , 'danger');
        return redirect("FNProductAdvance");
      }

      /**
      *INFORMATION MESSAGE CONTAINS
      *ACCOUNTS UPGRADE MESSAGE OR OTHER STUFFS
      */
      if(!empty($message)){
        Flash::set(implode(',' , $message) , 'info' , 'purchase_message');
      }

      Flash::set("Product Advance Purchase with payment successful! Product : $code->name");
      return redirect("FNProductAdvance");


    }



    /*
    *Store purchase
    */
    public function payment()
    {
      if($this->request() === 'POST')
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

          $post = request()->inputs();

          //get loan detail
          $loan_info = $this->fnproductBorrower->loanInfo($post['loan_id']);
        
          $codeId           =  $loan_info->code_id;
          $amount           =  $post['amount'] - $loan_info->delivery_fee;
          $delivery_fee     =  $loan_info->delivery_fee;
          $user_id          =  $loan_info->userid;

          /*TEMPORARY
          *CHANGE THIS EXECUTION
          */
          $imageUpload = upload_image('payment_picture' , $this->pathUpload);

          if($imageUpload['status'] == 'failed') {

            Flash::set("Image upload failed" , 'danger');
            return request()->return();
          }

          $paymentPictureFileName = $imageUpload['result']['name'];

          /*
          *purchaser information
          */
          $purchaser = $this->userModel->get_user($user_id);
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

     
          /********************************************
          *** IF product purchase is for activation ***
          *** 1.get code library with the following parameters
          *** 2.update code status to used
          **************************/
          if($code->category == 'activation')
          {
            /*
            *CHECK FOR CODE LIBRARY AVAILABILITY
            */

            $codelibrary = $this->fncodeInventory->getCodeWith([
              'drc_amount'      => $code->drc_amount,
              'unilevel_amount' => $code->unilevel_amount,
              'binary_point'    => $code->binary_point,
              'level'           => $code->level,
              'status'          => $code->status,
              'branchid'        => $loan_info->branchId
            ]);

            /*
            *No Available codes
            */
            if(!$codelibrary)
            {
              Flash::set("Branch $branch->name has no available code activation for the purchase" , 'danger');
              return request()->return();
            }

            /**
            *UPDATE CODELIBRARY TO USED
            */
            $this->fncodeInventory->dbupdate([
              'status' => 'used'
            ] , $codelibrary->id);

            /********************************************
            *** CHECK IF PURCHASER CAN BE UPGRADED ***
            *** 1.Compare purchaser maxpair to purchased product maxpair
            *** 2.Update if purchased code's maxpair is greater
            **************************/
            if($purchaser->max_pair < $codelibrary->max_pair)
            {
              $upgradeAccount = $this->userModel->dbupdate([
                'max_pair' => $codelibrary->max_pair,
                'status'    => $codelibrary->level
              ] , $purchaser->id);

              if($upgradeAccount)
              {
                $message[] = "Account {$purchaser->username} has been upgraded to {$codelibrary->level}";
              }else{
                $errors[] = "Account Upgrade for account {$purchaser->username} failed";
              }
            }
          }

          /********************************************
          *** INVENTORY TRANSACTIONS AND LOGGING ***
          ********************************************/

          /*store status of execution here*/
          $cashTransactions = [];

          $cashTransactions['payment'] = $this->fnproductReleasePayment->store([
            'userId'       => $purchaser->id ,
            'loanId'       => $post['loan_id'],
            'amount'       => $amount,
            'branchId'     => $branchid,
            'image'        => $paymentPictureFileName,
            'cashier_id'   => $branchManager->id,
            'category'     => 'product-loan'
          ]);

          /*
          *Cash Inventory Transaction Description
          */
          $description  = str_escape("Loan Payment for loan #{$loan_info->code} , payment by <b>{$purchaser->fullname}</b>");


          $cashTransactions['inventory'] = $this->fncashInventory->store([
            'branchid' => $branchid,
            'amount'   => $amount,
            'cashier_id' =>  $stock_manager,
            'description' => $description
          ]);

          if($delivery_fee) {
            /*ADD DELIVERY FEE*/
            $cashTransactions['inventory'] = $this->fncashInventory->store([
              'branchid' => $branchid,
              'amount'   => $delivery_fee,
              'cashier_id' =>  $stock_manager,
              'description' => "Delivery Fee for loan #{$loan_info->code}"
            ]);

            $message[] = "Shipping fee of {$delivery_fee} has been added";
          }


          /**STORE ERROR LOGS OF CASH TRANSACTIONS**/
          if(!$cashTransactions['payment'])
            $errors[] = "Cash Transaction release failed";

          if(!$cashTransactions['inventory'])
            $errors[] = "Cash Transaction inventory failed";


          /*
          Update to PAID
          */
          $this->fnproductBorrower->update_loan_status($post['loan_id']);


          /********************************************
          *** COMMISSIONS AND PAY-INS LOGGING ***
          ********************************************/
          $commission = [
            'purchaserid' => $purchaser->id,

            'commissions' => [
              'unilevelAmount' => $code->unilevel_amount,
              'drcAmount'      => $code->drc_amount,
              'binaryPoints'   => $code->binary_point,
              'level'  => $code->level
            ],

            'orderid' => 0 ,

            'distribution' => $code->distribution,
            'company'      => 'Break-Through'
          ];

          $payin = [
            'purchaserid' => $purchaser->id,
            'amount'      => $amount ,
            'type'        => 'code' ,
            'origin'      => 'Break-Through'
          ];

          $commissionParam = [
           $commission['purchaserid'],
           $commission['commissions'],
           $commission['orderid'],
           $commission['distribution'],
           $commission['company']
          ];


          $payinParam = [
            $payin['purchaserid'] ,
            $payin['amount'] ,
            $payin['type'] ,
            $payin['origin']
          ];

          $commissionTransacation['payout']  = $this->commission->submit_commissions( ...$commissionParam );

          $commissionTransacation['payin'] = $this->payin->make_payin( ...$payinParam );

          /**STORE ERROR LOGS OF COMMISSION TRANSACTIONS**/
          if(!$commissionTransacation['payout'])
            $errors[] = "Commission Transaction payin failed";

          if(!$commissionTransacation['payin'])
            $errors[] = "Commission Transaction payout failed";
          /*
          *IF ERROR OCCURED
          *ON ALL OPERATION
          */

          if(!empty($errors)) {
            Flash::set(implode(',' , $errors) , 'danger');
            return redirect("FNProductAdvance");
          }

          /*Account Creation (BINARY SPREADYY)*/
          if(in_array($code->level , ['bronze' , 'silver' , 'gold']))
          {
            $accountMaker = new AccountMakerObj($purchaser->id , $code->level);
            $accountMaker->run();
          }
          /**
          *INFORMATION MESSAGE CONTAINS
          *ACCOUNTS UPGRADE MESSAGE OR OTHER STUFFS
          */
          if(!empty($message)){
            Flash::set(implode(',' , $message) , 'info' , 'purchase_message');
          }

          Flash::set("Product Loan. payment successful! Product : $code->name");
          return redirect("FNProductAdvance");

      }else{

          $data = [];

          /*
          *check if a user is not set
          */
          if(!isset($_GET['user_id'])) {
            Flash::set("Invalid Request, a user must be set" , 'danger');
            return redirect('FNProductAdvance/');
          }


          /*
          *Check if user is set
          *then view is create purchase
          */
          $user_id = $_GET['user_id'];

          $user = $this->userModel->get_user($user_id);

           $loan_info = $this->fnproductBorrower->loanInfo($post['loan_id']);

          $mainForm = 'formPurchaseAndPay';

          $data = [
            'userInfo' => $user ,
            'loan_id' => $_GET['loan_id'],
            'codes' => $this->code->dbget_assoc('name'),
            'input' => [
              'required' => [
                'form' => $mainForm,
                'class' => 'form-control',
                'required' => ''
              ],

              'form' => $mainForm
            ]
          ];

          return $this->view('product_advance/make_payment' , $data);
      }    
    }

   /* public function update_product_release()
    {
      dump($this->fnproductBorrower->update_product_release());
    }*/
  }
