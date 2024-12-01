<?php 

    class API_UserMeta extends Controller {

        public function __construct()
        {
            parent::__construct();
            $this->userMetaModel = model('UsermetaModel');
        }

        /**
         * temporary used in user registration
         * for loan
         */
        public function saveLoanAmount() {
            $post = request()->posts();
            $response = $this->userMetaModel->saveEntry([
                'userid' => $post['userId'],
                'meta_key' => 'LOAN_AMOUNT_REQUEST',
                'meta_value' => $post['loanAmount']
            ]);

            echo api_response([
                'data' => $post,
                'dataEntry' => [
                    'userid' => $post['userId'],
                    'meta_key' => 'LOAN_AMOUNT_REQUEST',
                    'meta_value' => $post['loanAmount'],
                    'meta_value_type' => 'string',
                ],
                'response' => $response
            ]);
        }
    }