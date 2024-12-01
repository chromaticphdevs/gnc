<?php 

    class TopupController extends Controller
    {

        public function __construct()
        {
            parent::__construct();

            $this->top_up_model = model('TopupModel');
            $this->qr_code_model = model('UserOwnedQRModel');
        }

        public function topUp()
        {
            if( $this->request() === 'POST' )
            {
                $user_id = whoIs()['id'];
                $post = request()->inputs();

                $res = $this->top_up_model->save([
                    'user_id' => $user_id,
                    'point'  => 1,
                    'type' => $this->top_up_model::$TYPE_ADD
                ]);

                if($res) {
                    Flash::set("OK!");
                    $this->qr_code_model->use($post['id'] , $user_id);
                    return request()->return();
                }
            }
        }
    }