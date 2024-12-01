<?php
    use Service\UserService;
    load(['UserService'],APPROOT.DS.'services');

    class PackageController extends Controller
    {

        public $title = 'Product';

        public function __construct()
        {
            parent::__construct();
            $this->package_model = model('FNCodeStorageModel');
            $this->code_inventory_model = model('FNCodeInventoryModel');
            $this->user_service = new UserService();

            Authorization::setAccess([$this->user_service::ADMIN_TYPE, $this->user_service::EMPLOYEE_TYPE]);
        }

        public function index()
        {
            $packages = $this->package_model->getPackages();
            $data = [
                'packages' => $packages,
                'title'    => $this->title
            ];

            return $this->view('package/index' , $data);
        }

        public function create()
        {
            if (isSubmitted()) {
                $post = request()->posts();
                $res = $this->package_model->createOrUpdate( $post );

                if ($res) {
                    Flash::set("Package Created");
                }else{
                    Flash::set("Package create failed" , 'danger');
                }
                return redirect('PackageController/index');
            }

            $data = [
                'title' => 'Create Product',
                'user_service' => $this->user_service
            ];
            return $this->view('package/create_or_edit' , $data);
        }

        public function edit($id)
        {
            if (isSubmitted()) {
                $post = request()->posts();
                $res = $this->package_model->createOrUpdate( $post ,$post['id']);

                if(!$res){
                    Flash::set($this->package_model->getErrorString() , 'danger');
                    return request()->return();
                }else{
                    Flash::set( $this->package_model->getMessageString());
                }
                return redirect('PackageController/index');   
            }   

            $package = $this->package_model->get_code_lib_info($id);

            $data = [
                'title' => 'Edit Product',
                'user_service' => $this->user_service,
                'package' => $package,
                'id' => $id
            ];
            return $this->view('package/create_or_edit' , $data);
        }

        public function show($id)
        {
            $package = $this->package_model->get_code_lib_info($id);
            $packageCodes =  $this->package_model->getPackageCodes($id);

            $data = [
                'title' => 'Edit Package',
                'user_service' => $this->user_service,
                'package' => $package,
                'id' => $id,
                'packageCodes' => $packageCodes,
                'csrf' => csrfGet()
            ];

            return $this->view('package/show' , $data);
        }


        public function addItem()
        {
            if (isSubmitted()) {
                $post = request()->posts();
                $res = $this->code_inventory_model->generate_codes($post['package_id'] , $post['quantity']);

                if($res) {
                    Flash::set("Created {$post['quantity']} package codes");
                }

                return request()->return();
            }
        }

        public function delete($id)
        {
            $csrfParam = request()->input('csrf');
            $csrf = csrfGet();
            csrfReload();

            if (!isEqual($csrfParam , $csrf)) {
                Flash::set("Invalid Csrf Parameter!");
                return request()->return();
            }
            
            $this->package_model->dbdelete([
                'id' => $id
            ]);

            Flash::set("Package Deleted");
            return redirect('packageController/index');
        }

        /**
         * activate the code price so the code will be shown
         */
        public function activateCodePrice($codeId)
        {
            $param = request()->inputs();
            $csrf = csrfGet();
            csrfReload();
            //check csrf
            if (!isEqual($param['csrf'] , $csrf)) {
                Flash::set("Invalid Request");
                return request()->return();
            }

            $this->code_inventory_model->activateCodePrice($codeId , $param['package_id'] ,$param['price']);
            Flash::set("Code price set");

            return request()->return();
        }
    }