<?php   

    class TocController extends Controller
    {   

        public function __construct()
        {
            $this->toc = model('TOCModel');
            
            $this->borrowerCX = model('FNProductBorrowerCXModel');
            
        }

        public function haha()
        {
           $tocPassers = $this->toc->haha();
        }

        public function index($position = null)
        {
            $position = $position ?? 2;

            $package_id = 1;
            $quantity = 1;
            $qty_list = array("x","x", "x", "5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20", "24", "28", "30", "36", "36", "60");

            if($position == 1)
            {
               $package_id = 17;
            }else if($position == 2)
            {
              $package_id = 1;
            }else if($position >=3 && $position <=19)
            {
               $package_id = 5;
               $quantity =  $qty_list[$position];
            }

            $tocPassers = $this->toc->getByPosition( $position );

            $isCsr = true;
            $isStockManager = true;
            $whoIsType = whoIs()['type'];

            if( !isEqual( $whoIsType , CSR_TYPE) )
              $isCsr = false;

            if( !isEqual( $whoIsType , STOCK_MANAGER_TYPE))
              $isStockManager = false;

            $data = [
                'tocPassers' => $tocPassers,
                'productAutoloan'  => mGetCodeLibraries($package_id),
                'qty' =>  $quantity,
                'position' => $position,
                'isCsr'  => $isCsr,
                'isStockManager' => $isStockManager
            ];

             $linksAndButtons = [
                'previewLink' => '/company-customers-follow-ups/show',
                'updateController' => '/company-customers-follow-ups/update',
            ];

            $data['linksAndButtons'] = $linksAndButtons;


            return $this->view('finance/toc/index' , $data);
        }

        public function get_standby()
        {
            $data = [
                'tocPassers' => $this->toc->getByStandby(),
                'position'   => 'On Stand By '
            ];
            
            return $this->view('finance/toc/standy_by' , $data);
        }

        public function position1_standby($userid)
        {

          $userId = unseal($userid);

          //move to next step for TOC 
          $this->toc->move($userId, $_GET['loanid']);

          $this->toc->standBy($userId);
        

          Flash::set("Client is Now on the Standby List");
          return request()->return();

        }

        public function move_to_standby($userid)
        {

          $unsealedId = unseal($userid);

          $res = $this->toc->standBy($unsealedId);

          Flash::set("Client is Now on the Standby List");
          return request()->return();

        } 
        public function remove_to_standby($userid)
        {

          $res = $this->toc->remove_standBy(unseal($userid));

          Flash::set("Client is Removed to Standby List");
          return request()->return();

        }


        private function migrateToCorrespondingPosition($paymentAmount , $toc)
        {
          $retval = false;
            

          echo $paymentAmount.'<br/>';

          if(isEqual($toc->position , 7))
          {
            if($paymentAmount < 5845 ||$paymentAmount >7285) 
            {
              echo $paymentAmount;
              //update to pos 19
              $res = $this->toc->updateById([
                'position' => 19
              ] , $toc->id);

              if($res) {
                $retval = true;
              }
            }else{
              echo $paymentAmount;
            }      

            return $retval;
          }else{
            echo $toc->position;
          }
        }

        public function moveToShipment($userId)
        {

          $unsealedId = unseal($userId);
          
          $isUpdate = $this->toc->moveToShipping( $unsealedId , 0);

          if($isUpdate) {
            Flash::set("Updated");
          }

          return request()->return();
        }

          public function change_position()
        {

          $this->toc->change_position(unseal($_POST['userId']),$_POST['position']);

          Flash::set("Position Changed");
          return request()->return();

        }
    }   