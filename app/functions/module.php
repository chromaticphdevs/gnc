<?php 	
  

  function mTocForShipment($userId)
  {
    $tocModel = model('TOCModel');
    $toc = $tocModel->getByUser($userId);

    if(!$toc)
      return false;

    if($toc->is_for_shipment)
      return true;

    return false;
  }
	function mGetCodeLibraries($id)
	{
		$model = model('INCodelibraryModel');
		return $model->get($id);
	}


	/*
	*@params
	*codeId,
	*amount,quantity,delivery_fee,user_id
	*/
	function mAutoloan( $parameters = [])
	{
	  $messages = [];
      $errors   = [];

      $codeId = $parameters['codeId'];
      $amount = $parameters['amount'];
      $quantity = $parameters['quantity'];
      $delivery_fee = $parameters['delivery_fee'];
      $shipping_details = $parameters['shipping_details'];
      $user_id = $parameters['user_id'];

      $userModel = model('User_model');
      $codeModel = model('INCodelibraryModel');
      $branchInventoryModel = model('FNItemInventoryModel');
      $branchModel         = model('FNBranchModel');
      $productModel = model('INProductModel');

      $fnProductBorrowerModel = model('FNProductBorrowerModel');
      $fnproductReleaseModel = model('FNProductReleaseModel');

      if(Session::check('USERSESSION')) {
        $branchManager = $userModel->get_user(Session::get('USERSESSION')['id']);
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




 
      $purchaser = $userModel->get_user($user_id);

      if(empty($purchaser))
      {
        Flash::set("Error no Prurchaser Info" , 'danger');
        return request()->return();
      }

      /*
      *Code Library
      */
      $code = $codeModel->dbget($codeId);
      /*
      * GET PRODUCT INFORMATION
      */
      $product = $productModel->dbget($code->product_id);
      /*
      *GET BRANCH INFORMATION
      */
      $branch = $branchModel->dbget($branchid);
      /*
      *CHECK FOR BRANCH STOCKS OF THE PRODUCT
      */
      $productStocks = $branchInventoryModel->getProductStocksByBranch($code->product_id , $branchid);

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
      $inventoryTransactionCode = $fnProductBorrowerModel->make_code();

      $stockTransactions = [];

      if($purchaser->id == 0 )
      {
        Flash::set("Error no Prurchaser Id" , 'danger');
        return request()->return();
      }

      $stockTransactions['release'] = $fnproductReleaseModel->store([
        'userid' => $purchaser->id,
        'code'   => $inventoryTransactionCode,
        'code_id' => $codeId,
        'amount' => $amount,
        'quantity' => $quantity,
        'branchid' => $branchid,
        'category' => 'product-loan',
        'stock_manager' =>  $stock_manager,
        'delivery_fee' => $delivery_fee,
        'shipping_details' => $shipping_details,
        'product_name' => $product->name,
        'status'  => 'Approved'
      ]);


      $stockTransactions['inventory'] = $branchInventoryModel->store([
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


      $retVal = [
        'status' => true,
        'loanReference' => $inventoryTransactionCode,
        'loanId' => $stockTransactions['release'],
        'code'   => $code,

        'models' => [
          'user' => $userModel,
          'code' => $codeModel,
        ]
      ];

      return $retVal;
	}