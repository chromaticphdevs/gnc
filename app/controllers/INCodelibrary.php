<?php

  class INCodelibrary extends Controller
  {

    private $activationLevels = [
			'starter' , 'bronze' , 'silver' , 'gold' , 'platinum' , 'diamond', 'Product Loan', 'Rejuve Set', 'Rejuve Set for Activated', 'Product Repeat purchase'
		];

    public function __construct()
    {
      $this->fncode = $this->model('FNCodeStorageModel');
      $this->product = $this->model('INProductModel');
      $this->code = $this->model('INCodelibraryModel');

    }

    public function index()
    {
      $data = [
        'codes' => $this->code->dbget_assoc('name')
      ];

      return $this->view('inventory/code_libraries/index' , $data);
    }

    public function create()
    {
      $data = [
        'codes' => $this->fncode->dbget_assoc('name'),
        'products' => $this->product->dbget_assoc('name')
      ];

      return $this->view('inventory/code_libraries/create' , $data);
    }

    public function store()
    {
      $post = request()->inputs();
      //get code
      $code = $this->fncode->dbget($post['code_id']);
      $product = $this->product->dbget($post['product_id']);
      $originalAmount = $post['amount_original'];
      $discountedAmount = $post['amount_discounted'];

      $result = $this->code->store([
        'product_id'     => $post['product_id'],
        'name'           => $code->name,
        'box_eq'         => $code->box_eq,
        'drc_amount'     => $code->drc_amount,
        'unilevel_amount'   => $code->unilevel_amount,
        'binary_point'   => $code->binary_point,
        'distribution'   => $code->distribution,
        'level'          => $code->level,
        'max_pair'       => $code->max_pair,
        'status'         => $code->status,
        'amount_discounted'   => $post['amount_discounted'],
        'amount_original'   => $post['amount_original'],
        'category'   => $post['category'],
      ]);

      Flash::set("Code $code->name Created");

      if(!$result)
        flash_err();

      return redirect("INCodelibrary");
    }

    public function edit($code_id)
    {
      $code = $this->code->dbget($code_id);

      $data = [
        'code' => $code,
        'codes' => $this->fncode->dbget_assoc('name'),
        'products' => $this->product->dbget_assoc('name'),
        'levels'   => $this->activationLevels
      ];

      return $this->view('inventory/code_libraries/edit' , $data);
    }

    public function update()
    {
      $post = request()->inputs();
      /*
      *Store here the updated data
      */
      $updatedData = array_remove_kitem(['submit', 'id'] , $post);

      $result = $this->code->dbupdate($updatedData , $post['id']);

      Flash::set("Code updated");

      if(!$result)
        flash_err();

      return redirect("INCodelibrary/edit/{$post['id']}");
    }
  }
