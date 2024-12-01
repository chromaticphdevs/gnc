<?php 
    use Service\UserService;
    use Classes\User\Ranking;

    load(['UserService'] , APPROOT.DS.'services');
    load(['Ranking'] , CLASSES.DS.'User');

    class UserRegisterController extends AdminController
    {
        public function __construct()
        {
            parent::__construct();

            Authorization::setAccess([UserService::ADMIN_TYPE , UserService::EMPLOYEE_TYPE , UserService::CUSTOMER_TYPE]);

            $this->user_model = model('User_model');
            $this->user_service = new UserService();

            $this->code_model = model('FNCodeInventoryModel');
        }

        /**
         * Only use this if the user is a customer
         * otherwise skip
         */
        private function searchActivationCode($activation_code_code)
        {
            $activation_code = $this->code_model->get_by_code($activation_code_code);

            if(!$activation_code) {
                $this->err_activation_code = " Activation Code Not Found";
                return false;
            }

            return $activation_code;
        }

        public function create()
        {
            $errors = [];
            $staffing_user_types  = [
                $this->user_service::ADMIN_TYPE,
                $this->user_service::EMPLOYEE_TYPE,
            ];
            $users = $this->user_model->get_list("WHERE user_type not in ('".implode("','" , $staffing_user_types)."') ");
            $users = arr_layout_keypair($users , ['id' , 'username']);
            $data = [
                'title' => 'Register User',
                'user_types' => $this->user_service->getUserTypes(),
                'users' => $users
            ];
            if (isSubmitted()) {
                $post = request()->posts();
                
                /**
                 * Inject user rankname
                 */
                $post['rank_name'] = UserService::RANK_STARTER;

                $is_member = isEqual($post['user_type'], $this->user_service::CUSTOMER_TYPE);

                $activation_code =  null;

                $is_sub_account = false;

                 /**
                 * if user registered is customer type
                 * then add initial checks
                 */
                if ($is_member) {
                    $activation_code = $this->searchActivationCode( $post['activation_code'] );
                    /**
                    * No need to continue comission since activation code is not valid
                    */
                    if (!$activation_code) {
                        Flash::set( $this->err_activation_code , 'danger');
                        return request()->return();
                    }

                    if (isEqual($activation_code->status , 'used')) {
                        Flash::set("Activation code is already used" , 'warning');
                        return request()->return();
                    }

                    /**
                     * Also checks for upline and direct-sponsor
                     */

                     if (empty($post['upline'])) {
                        Flash::set("Upline Should not be empty!" , 'warning');
                        return request()->return();
                     }

                     /**
                      * search accounts of 
                      *upline
                      */
                    $user_upline = $this->user_model->getByUsername($post['upline']);

                    $account_exists = $this->user_model->subAccountChecking($post);

                    if (!$user_upline)
                        $errors[] = " Upline username not found!";

                    if ($account_exists)
                        $is_sub_account = true;
                }

                if (!empty($errors)) {
                    Flash::set( implode(',' , $errors) , 'danger  ');
                    return request()->return();
                }
                
                /**
                 * add new member
                 * upline
                 */
                if ($is_member)
                    $post['upline'] = $user_upline->id;
                
                if ($is_sub_account) {
                    /**
                     * show main-account first
                     * returning a view
                     */
                    if( !isset($post['confirm_create_sub_account']) ){
                        $data['main_account'] = $this->user_model->main_account;
                        return $this->view('user/register' , $data);
                    }
                    $post['account_tag'] = 'sub_account';   
                    $user_id = $this->user_model->createSubAccount($post , $this->user_model->main_account->id);                
                } else {
                    $user_id = $this->user_model->create($post);
                }
                
                if (!$user_id) {
                    Flash::set( $this->user_model->getErrorString() , 'danger');
                    return request()->return();
                }

                if ($user_id) {
                    $this->code_model->update_status($activation_code->id , 'used');
                    //commission
                    $this->triggerComission($user_id);
                    $this->triggerIncentive($user_upline);

                    Flash::set("User {$post['username']} has been created , successfully");
                    if(isEqual(whoIs('type') , $this->user_service::CUSTOMER_TYPE)) 
                        return redirect('team/details');
                    return redirect('account/list');
                } else {
                    Flash::set("Something went wrong!");
                }
            }
            
            $data['user_service'] = $this->user_service;
            return $this->view('user/register' , $data);
        }

        private function triggerComission( $user_id )
        {
            $uplines = get_user_uplines($user_id);
            //total distro
            $totalDistro = 0;
            foreach ($uplines as $key => $row) {
                if( $totalDistro >= 6) 
                    break;
                CommissionTransactionModel::make_commission($row->id , $user_id , 'UNILEVEL' , 50 , 'BREAKTHROUGH-E');
                $totalDistro ++;
            }
        }

        private function triggerIncentive($user_upline)
        {
            $uplines = get_user_uplines($user_upline->id);
            
            if (is_array($uplines) && count($uplines) >= 10) {
                $this->note_model = model('UserNoteModel');
                $this->note_model->addNote($user_upline->id , "10 upline incentive");
            }
        }
    }
