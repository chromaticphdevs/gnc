<?php   

    /**
     * IN Inventory prefix
     * Database stored in schema/inventory
     */
    class INProduct extends Controller 
    {

        public function __construct()
        {
            $this->branch = $this->model('FNBranchModel');
            $this->product = $this->model('INProductModel');

            $this->pathUpload = PATH_UPLOAD.DS.'inventory/product';
            $this->getPathUpload = GET_PATH_UPLOAD.DS.'inventory/product';

            $this->stockTypes = stocktypes(); //function can be found on fucntion folder
        }

        public function index()
        {
            $data = [
                'products' => $this->product->dball(),
                'uploadPath' => $this->getPathUpload
            ];

            return $this->view('inventory/product/index' , $data);
        }

        public function create()
        {
            $data = [
                'stock_types' => $this->stockTypes
            ];

            return $this->view('inventory/product/create' , $data);
        }

        public function store()
        {
            $post = request()->inputs();

            $code = get_token_random_char(10,'I');

            $name = $post['name'];
            $description  = $post['description'];
            $capital    = $post['capital'];
            $sell_price    = $post['sell_price'];
            $stock_type    = $post['stock_type'];

            $image = upload_image('image' , $this->pathUpload);

            if($image['status'] == 'success') {
                //set image to image name
                $image  = $image['result']['name'];
            }else{
                $image = '';
            }

            $result = $this->product->store([
                'code'          => $code,
                'name'          => $name,
                'image'         => $image,
                'path_upload'   => $this->pathUpload,
                'description'   => $description,
                'capital'       => $capital,
                'sell_price'    => $sell_price,
                'stock_type'    => $stock_type,
            ]);

            Flash::set("Product {$name} Saved");

            if(!$result) {
                //flash error message
                flash_err();
            }

            return redirect("INProduct");
        }


        public function edit($product_id)
        {
            $data = [
                'product' => $this->product->dbget($product_id),
                'uploadPath' => $this->getPathUpload,
                'stock_types' => $this->stockTypes
            ];
            
            return $this->view('inventory/product/edit' , $data);
        }

        public function update()
        {   
            $post = request()->inputs();

            $id = $post['id'];
            $code = $post['code'];
            $name = $post['name'];
            $description  = $post['description'];
            $capital    = $post['capital'];
            $sell_price    = $post['sell_price'];
            $stock_type    = $post['stock_type'];

            /**
             * UPDATE DETAILS EXCEPT IMAGE
             */
            $result = $this->product->dbupdate([
                'code'          => $code,
                'name'          => $name,
                'description'   => $description,
                'capital'       => $capital,
                'sell_price'    => $sell_price,
                'stock_type'    => $stock_type
            ],$id);

            /**
             * If Image is filled
             */
            if(!empty($_FILES['image'])) 
            {
                $image = upload_image('image' , $this->pathUpload);

                if($image['status'] == 'success')
                {
                    //update image

                    $result = $this->product->dbupdate([
                        'image'          => $image['result']['name'],
                        'path_upload'    => $image['result']['path']
                    ],$id);
                }
            }

            Flash::set("Product {$code}:{$name} updated");
            if(!$result) {
                flash_err();
            }

            return redirect("INProduct/edit/{$id}");
        }
    }