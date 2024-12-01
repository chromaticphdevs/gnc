<?php 	
	
	class ProductLoan extends Controller
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
	      $this->toc = $this->model('TOCModel');

	      /*
	      *COMMISSION TRANSACTION MODEL
	      */
	      $this->commission = $this->model('commissiontrigger_model');
	      $this->payin     = $this->model('LDPayinModel');
		}

		public function show($id)
		{
			$loanId = unseal($id);

			$loan = $this->fnproductBorrower->loanInfo($loanId);

			$userInfo = $this->userModel->get_user($loan->userid);

			$loanPayment = $this->fnproductReleasePayment->getPayment($loanId);

			$balance = $loan->total - $loanPayment['total'];

			$data = compact([
				'userInfo',
				'loan',
				'loanPayment',
				'balance'
			]);

			return $this->view('product_advance/loan_view' , $data);
		}

		public function makePayment()
		{
			
			$messages = [];
		    $errors   = [];

			$post = request()->inputs();

			$amountPayment = $post['amount_payment'];
			$paymentFor = $post['payment_for'];

			//loan
			$loan = $this->fnproductBorrower->loanInfo($post['loan_id']);
			$loanPayment = $this->fnproductReleasePayment->getPayment($post['loan_id']);

			//delivery balance
			$deliveryBalance = ($loan->delivery_fee - $loanPayment['deliveryAmount']);
			//product balance
			$productBalance = ($loan->amount - $loanPayment['productAmount']);

			//check what payment

			if( isEqual($paymentFor , 'product') )
			{
				if($amountPayment > $productBalance) 
					$errors[] =" Payment must not be greater that balance";
			}else{
				if($amountPayment > $deliveryBalance) 
					$errors[] = " Payment must not be greater that balance";
			}

			if(!empty($errors)) {
				Flash::set(implode(',', $errors) , 'danger');
				return request()->return();
			}

	

			 // make payments and store to cash inventory

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

		      $codeId           =  $loan->code_id;
		      $amount           =  $amountPayment;
		      $user_id          =  $loan->userid;
		      $note             =  $post['note'];

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

		      //***get unilvl multiplier***
		      $unilvl_multiplier = 1;
		     
		      if(isEqual($code->category, "non-activation"))
		      {
		        $unilvl_multiplier = $loan->quantity;
		      }

		      /*
		      * GET PRODUCT INFORMATION
		      */
		      $product = $this->product->dbget($code->product_id);
		      /*
		      *GET BRANCH INFORMATION
		      */
		      $branch = $this->branch->dbget($branchid);


		      //----------check if paid
			  $remainingBalance = $loan->total -  ($loanPayment['total'] + $amountPayment);

			  $status = 'Approved';
				
			  if($remainingBalance == 0)
					$status = 'Paid';
			  //----------check if paid end

			  if(isEqual($status , 'Paid'))
			  {
			      /********************************************
			      *** IF product purchase is for activation ***
			      *** 1.get code library with the following parameters
			      *** 2.update code status to used
			      **************************/
			      if(isEqual($code->category , 'activation'))
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

			      /*
			      Update to PAID
			      */
			      $this->fnproductBorrower->update_loan_status($loan->id);



				/********************************************
			      Move to next step if the loan is for TOC create loan
			      */
			      //move to next step for TOC 
   				 // $this->toc->moveToNextStep($purchaser->id, $post['loan_id']);



			      /********************************************
			      *** COMMISSIONS AND PAY-INS LOGGING ***
			      ********************************************/
			      $commission = [
			        'purchaserid' => $purchaser->id,

			        'commissions' => [
			          'unilevelAmount' => $code->unilevel_amount * $loan->quantity,
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
			  } 


		      /********************************************
		      *** INVENTORY TRANSACTIONS AND LOGGING ***
		      ********************************************/
		      /*INITIATE DESCRIPTIONS*/

		      /*
		      *Cash Inventory Transaction Description
		      */
		      $category = 'product-loan';
		      
		      $description  = str_escape("Loan Payment for loan #{$loan->code} , 
		       	payment by <b>{$purchaser->fullname}</b>"); 

		      if( isEqual($paymentFor , 'delivery')) {
		      	$category = 'delivery-fee';
		      	$description = str_escape("Delivery Fee for loan #{$loan->code}");
		      }

		      /*store status of execution here*/
		      $cashTransactions = [];

		      $cashTransactions['payment'] = $this->fnproductReleasePayment->store([
		        'userId'       => $purchaser->id ,
		        'loanId'       => $loan->id,
		        'amount'       => $amountPayment,
		        'branchId'     => $branchid,
		        'image'        => $paymentPictureFileName,
		        'cashier_id'   => $branchManager->id,
		        'category'     => $category,
		        'notes' 	   => $note
		      ]);

		      $cashTransactions['inventory'] = $this->fncashInventory->store([
		        'branchid' => $branchid,
		        'amount'   => $amountPayment,
		        'cashier_id' =>  $stock_manager,
		        'description' => $description
		      ]);

		      /**STORE ERROR LOGS OF CASH TRANSACTIONS**/
		      if(!$cashTransactions['payment'])
		        $errors[] = "Cash Transaction release failed";

		      if(!$cashTransactions['inventory'])
		        $errors[] = "Cash Transaction inventory failed";



	          //get total payment
	          $total_payment = 0;
	          $payments = $this->fnproductBorrower->get_payment_history($user_id);

	          foreach ($payments as $key => $value) {
	             
	            if(!isEqual($value->category, "delivery-fee"))
	                $total_payment += $value->amount;
	          }

	          $position = tocPosition($total_payment);
	          /********************************************
	          *** Moving to next step TOC ***
	          ********************************************/

	          $result = $this->toc->moving_to_next_step($user_id , $post['loan_id'], $position);
	          
	          if($result)
	             $message[] = "User moved to TOC step {$position}";


		      /**
		      *INFORMATION MESSAGE CONTAINS
		      *ACCOUNTS UPGRADE MESSAGE OR OTHER STUFFS
		      */
		      if(!empty($message)){
		        Flash::set(implode(',' , $message) , 'info' , 'purchase_message');
		      }

		      Flash::set("Product Loan. payment successful!");
		      return redirect("ClientPaymentSearch/");
		}

		public function showPayments($loanId)
		{
			$payments = $this->fnproductReleasePayment->getPayments($loanId);

			$path = URL.DS.'public/assets/payment_image';

			return $this->view('product_advance/payments' , compact(['payments' , 'path']));
		}	
	}