<?php 

    class API_Binary60PairCommission extends Controller
    {


        public function index()
        {
            
            $binary60PairCommission = new Binary60PairCommission();
            $commission_trigger_model = model('Commissiontrigger_model');
            $top_up_model = model('TopupModel');

            // $binary60PairCommission->computeAndSave(8 , 'right' , 1);

            // $commission_trigger_model->add_binary_points(11);

            $res = $top_up_model->save([
                'user_id' => $_GET['user_id'],
                'point'  => 1,
                'type' => $top_up_model::$TYPE_ADD
            ]);

            dump([
                'abc',$res
            ]);
        }
    }