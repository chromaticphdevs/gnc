<?php
  /*
  *Buy product with payment attached
  */
  class OrderingSystem extends Controller
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
      $this->FNCashAdvanceModel = $this->model('FNCashAdvanceModel');

      /*
      *COMMISSION TRANSACTION MODEL
      */
      $this->commission = $this->model('commissiontrigger_model');
      $this->payin     = $this->model('LDPayinModel');

      $this->TOCModel = $this->model('TOCModel');
    }

    public function index()
    {
      /*SEARCH USER*/
      check_session();
      Session::remove('CARTLIST');  
      return $this->view('ordering_system/search_user');
    }

    /*
    *GET REQUEST
    */
    public function create()
    {
        check_session();
        $data = [];

        /*
        *check if a user is not set
        */
        if(!isset($_GET['user_id']) || empty($_GET['user_id'])) {
          Flash::set("Invalid Request, a user must be set" , 'danger');
          return request()->return();
        }

        /*
        *Check if user is set
        *then view is create purchase
        */
        $user_id = $_GET['user_id'];

        $user = $this->userModel->get_user($user_id);

        $mainForm = 'formPurchaseAndPay';

        $myCart = SESSION::get("CARTLIST");

        $data = [
          'userInfo' => $user ,
          'codes' => $this->code->dbget_assoc("name", "`status` = 'available'"),
          'loans' => $this->fnproductBorrower->get_user_loans($user_id),
          'myCart' => $myCart,
          'input' => [
            'required' => [
              'form' => $mainForm,
              'class' => 'form-control',
              'required' => ''
            ],

            'form' => $mainForm
          ]
        ];

        return $this->view('ordering_system/create' , $data);
    }

  
    public function show_cart()
    {
        check_session();
        
        if(!isset($_GET['user_id']) || empty($_GET['user_id'])) {
          Flash::set("Invalid Request, a user must be set" , 'danger');
          return request()->return();
        }

        $user_id = $_GET['user_id'];

        $user = $this->userModel->get_user($user_id);


        $mainForm = 'formPurchaseAndPay';

        $myCart = SESSION::get("CARTLIST");
        $total = 0;
        if(!empty($myCart)){
        
          foreach ($myCart as $key => $value)
          {
            $total += $value->amount;
          }
        }

        $data = [
          'userInfo' => $user ,
          'total' =>$total ,
          'myCart' => $myCart,
           'input' => [
            'required' => [
              'form' => $mainForm,
              'class' => 'form-control',
              'required' => ''
            ],

            'form' => $mainForm
          ]
        ];


        return $this->view('ordering_system/show_cart' , $data);
    }

    // add to cart
    public function add_cart()
    {
      $post = request()->inputs();

      $myCart = [];

      if(Session::check('USERSESSION')) {
        $branchManager = $this->userModel->get_user(Session::get('USERSESSION')['id']);
        $branchid = '8'; //if admin automatic to 8
      }

      if(Session::check('BRANCH_MANAGERS')) {
        $branchManager = Session::get('BRANCH_MANAGERS');
        $branchid = $branchManager->branchid;
      }

      $code = $this->code->dbget($post['code_id']);
       
      //CHECK FOR BRANCH STOCKS OF THE PRODUCT
      $productStocks = $this->branchInventory->getProductStocksByBranch( $code->product_id, $branchid);

      if(!$productStocks || $productStocks < $post['quantity']) {
        Flash::set("No stocks for product {$product->name}" , 'warning');
        return request()->return();
      }

      if(SESSION::check("CARTLIST"))
      {
         $myCart = SESSION::get("CARTLIST");
      }

      $cartObject = (object) [
        'product_name'=> $post['product_name'],
        'code_id'=> $post['code_id'],
        'amount' => $post['amount'],
        'quantity' => $post['quantity'],
        'user_id' => $post['user_id']
      ];

      array_unshift($myCart, $cartObject);

      Session::set('CARTLIST' ,  $myCart);
      return request()->return();
    }


    //removing items from the cart
    public function remove_item($index)
    { 
      $myCart = SESSION::get("CARTLIST");

      unset($myCart[$index]); 

      Session::set('CARTLIST' , $myCart);

      Flash::set("Item has been removed");
      return request()->return();
    }

    //restart cart list
    public function reset_cart()
    {
      Session::remove('CARTLIST');  
      Flash::set("Cart has been Reset");
      return request()->return();
    }


    /*
    *Store purchase
    */
    public function store()
    {

      $messages = [];
      $errors   = [];

      $myCart = SESSION::get("CARTLIST");
     
      if(empty($myCart))
      {
          Flash::set("ERROR Please Order Again" , 'danger');
          return redirect("/OrderingSystem");
      }

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

      //get order code
      $inventoryTransactionCode = $this->fnproductBorrower->make_code();

      foreach ($myCart as $key => $value) 
      {
          $codeId           = $value->code_id;
          $amount           = $value->amount;
          $quantity         = $value->quantity;
          $delivery_fee     = $post['delivery_fee']/count($myCart);
          $shipping_details = $post['shipping_details'];
          $user_id          = $post['user_id'];
          $note             = $post['note'];


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


          if(empty($purchaser))
          {
            Flash::set("Error Client Not Found" , 'danger');
            return request()->return();
          }
          /*
          *Code Library
          */
          $code = $this->code->dbget($codeId);

          //***get unilvl multiplier***
          $unilvl_multiplier = 1;
         
          if(isEqual($code->category, "non-activation"))
          {
            $unilvl_multiplier = $quantity;
          }

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
              'branchid'        => $branchid
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

          /*set the transactions code
          *This code will be used to tracked down
          *Inventory transaction relation
          */


          $stockTransactions = [];

          if($purchaser->id == 0 )
          {
            Flash::set("Error no Prurchaser Id" , 'danger');
            return request()->return();
          }
          /*
          LOAN ID
          */
          $stockTransactions['release'] = $this->fnproductRelease->store([
            'userid' => $purchaser->id,
            'code'   => $inventoryTransactionCode,
            'code_id' => $codeId ,
            'amount' => $amount,
            'quantity' => $quantity,
            'branchid' => $branchid,
            'category' => 'advance-payment',
            'stock_manager' =>  $stock_manager,
            'product_name' => $product->name,
            'delivery_fee' =>  $delivery_fee,
            'shipping_details' => $shipping_details,
            'status'  => 'Paid'
          ]);

          
          // if item purchase is Starter 4+4 add a loan repeat purchase 4 box 
          if($codeId == "16")
          {   
              $loanCode = $this->fnproductBorrower->make_code();
              $this->fnproductRelease->store([
              'userid' => $purchaser->id,
              'code'   => $loanCode,
              'code_id' => '5',
              'amount' => '640',
              'quantity' => '4',
              'branchid' => $branchid,
              'category' => 'product-loan',
              'stock_manager' =>  $stock_manager,
              'product_name' => $product->name,
              'delivery_fee' =>  '0',
              'shipping_details' => 'shipping_details',
              'status'  => 'Approved'
            ]);
          }


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

       

          /********************************************
          *** COMMISSIONS AND PAY-INS LOGGING ***
          ********************************************/
          $commission = [
            'purchaserid' => $purchaser->id,

            'commissions' => [
              'unilevelAmount' => $code->unilevel_amount * $unilvl_multiplier,
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
            return redirect("OrderingSystem");
          }

          /*Account Creation (BINARY SPREADYY)*/
          if(in_array($code->level , ['bronze' , 'silver' , 'gold']))
          {
            $accountMaker = new AccountMakerObj($purchaser->id , $code->level);
            $accountMaker->run();
          }

      }

      /*store status of execution here*/
      $cashTransactions = [];

      $cashTransactions['payment'] = $this->fnproductReleasePayment->store([
        'userId'       => $purchaser->id ,
        'order_code'   => $inventoryTransactionCode,
        'loanId'       => $stockTransactions['release'],
        'amount'       => $post['total_purchase'],
        'branchId'     => $branchid,
        'image'        => $paymentPictureFileName,
        'cashier_id'   => $branchManager->id,
        'category'     => 'advance-payment',
        'notes'        => $note
      ]);

      /*
      *Cash Inventory Transaction Description
      */
      $description  = str_escape("Loan Payment for loan #{$inventoryTransactionCode} , payment by <b>{$purchaser->fullname}</b>");


      $cashTransactions['inventory'] = $this->fncashInventory->store([
        'branchid' => $branchid,
        'amount'   => $post['total_purchase'],
        'cashier_id' =>  $stock_manager,
        'description' => $description
      ]);

      if($delivery_fee) {
        /*ADD DELIVERY FEE*/
        $cashTransactions['inventory'] = $this->fncashInventory->store([
          'branchid' => $branchid,
          'amount'   => $post['delivery_fee'],
          'cashier_id' =>  $stock_manager,
          'description' => "Delivery Fee for loan #{$inventoryTransactionCode}"
        ]);

        $message[] = "Shipping fee of {$delivery_fee} has been added";
      }


      /**STORE ERROR LOGS OF CASH TRANSACTIONS**/
      if(!$cashTransactions['payment'])
        $errors[] = "Cash Transaction release failed";

      if(!$cashTransactions['inventory'])
        $errors[] = "Cash Transaction inventory failed";

      /**
      *INFORMATION MESSAGE CONTAINS
      *ACCOUNTS UPGRADE MESSAGE OR OTHER STUFFS
      */
      if(!empty($message)){
        Flash::set(implode(',' , $message) , 'info' , 'purchase_message');
      }

      //insert to shipment pending

      Flash::set("Product Advance Purchase with payment successful! Product : $code->name");
      return redirect("OrderingSystem");
    }

  }
