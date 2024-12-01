<?php 

    class CACoBorrowerController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->caCoBorrowerModel = model('CashAdvanceCoBorrowerModel');
        }
        public function index() {

        }
        
        public function create() {

        }

        public function showInvite($requestId) {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                $resp = $this->caCoBorrowerModel->processApproval($post['id'], $post['co_borrower_approval'], $post['co_borrower_remarks']);

                if($resp) {
                    Flash::set("Invite has been processed");
                    return redirect('/FNCashAdvance/apply_now');
                } else {
                    Flash::set("Something went wrong");
                    return request()->return();
                }
            }
            $id = unseal($requestId);

            $requestInvite =  $this->caCoBorrowerModel->get([
                'id' => $id
            ]);
            
            $data = [
                'id' => $id,
                'requestInvite' => $requestInvite,
            ];
            return $this->view('ca_co_borrower/show_invite', $data);
        }
    }