<?php

  class Shop extends Controller
  {

    public $pathUpload = PUBLIC_ROOT.DS.'assets/payment_image/';

    public function __construct()
    {
       $this->code = $this->model('INCodelibraryModel');
       $this->userModel = $this->model('User_model');
       $this->branchInventory = $this->model('FNItemInventoryModel');
    }

    public function index()
    {
        check_session();
        $data = [];
        $mainForm = 'formPurchaseAndPay';

        $myCart = SESSION::get("CARTLIST");
        $total_item = 0;

        if(!empty($myCart)){
          foreach ($myCart as $key => $value) {
            $total_item += $value->quantity;
          }
        }

        $data = [

          'codes' => $this->code->dbget_assoc("name", "`status` = 'available'"),
          'myCart' => $myCart,
          'total_item' =>  $total_item,
          'input' => [
            'required' => [
              'form' => $mainForm,
              'class' => 'form-control',
              'required' => ''
            ],

            'form' => $mainForm
          ]
        ];

       return $this->view('shop/index' , $data);
    
    }

    // add to cart
    public function add_cart($code_id)
    {
  
      $myCart = [];

      if(Session::check('USERSESSION')) {
        $branchManager = $this->userModel->get_user(Session::get('USERSESSION')['id']);
        $branchid = '8'; //if admin automatic to 8
      }

      if(Session::check('BRANCH_MANAGERS')) {
        $branchManager = Session::get('BRANCH_MANAGERS');
        $branchid = $branchManager->branchid;
      }

      $code = $this->code->dbget(unseal($code_id));
       
      //CHECK FOR BRANCH STOCKS OF THE PRODUCT
      $productStocks = $this->branchInventory->getProductStocksByBranch( $code->product_id, $branchid);

      if(!$productStocks || $productStocks < 1) {
        Flash::set("No stocks for product {$product->name}" , 'warning');
        return request()->return();
      }

      if(SESSION::check("CARTLIST"))
      {
         $myCart = SESSION::get("CARTLIST");
      }
      $check = 0;
      $position;
      //update quantity if the product is already added
      if(!empty($myCart))
      {
        foreach ($myCart as $key => $value) {

            if($value->code_id == $code->id)
            {
               $check = 1;
               $position = $key;
            }
        }
      }
      if(empty($myCart) || $check == 0)
      {

        $cartObject = (object) [
          'product_name'=> $code->name,
          'code_id'=> $code->id,
          'amount' => $code->amount_original,
          'category' => $code->category,
          'many' => $code->many,
          'quantity' => 1,
          'image' => $code->image,
          'user_id' => Session::get('USERSESSION')['id']
        ];

        array_unshift($myCart, $cartObject);

        Session::set('CARTLIST' ,  $myCart);

      }else if($check == 1)
      {
         $myCart[$position]->quantity += 1;
      }

      Flash::set("Item has been Added to Cart");
      return request()->return();
    }

     public function show_cart()
    {
        check_session();
        $data = [];
        $mainForm = 'formPurchaseAndPay';

        $myCart = SESSION::get("CARTLIST");

        $data = [

          'codes' => $this->code->dbget_assoc("name", "`status` = 'available'"),
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

       return $this->view('shop/cart' , $data);
    
    }

    public function update_cart()
    { 
        $post = request()->inputs();
        
        $myCart = SESSION::get("CARTLIST");

        foreach ($post['quantity'] as $key => $value) {

         $myCart[$key]->quantity = $value;
        }

        Session::set('CARTLIST' , $myCart);

        Flash::set("Cart Updated");
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
   
  }
