<?php 
    use Services\QRTokenService;
    load(['QRTokenService'], APPROOT.DS.'services');

    class UniversalCodeController extends Controller
    {   

        public function __construct()
        {
            parent::__construct();

            $this->universal_code_model = model('UniversalCodeModel');
        }

        public function index()
        {
            $data = [
                'codes' => $this->universal_code_model->getAvailable(),
                'title' => 'Raffle Codes'
            ];

            return $this->view('universal_code/list' , $data);
        }

        public function print()
        {
            $data = [
                'codes' => $this->universal_code_model->getAvailable()
            ];

            return $this->view('universal_code/print' , $data);
        }

        public function create()
        {
            if( $this->request() === 'POST' )
            {
                $codes_created = $this->universal_code_model->createMultiple($_POST['quantity'] , [
                    'description' => $_POST['description']
                ]);

                if( !empty($codes_created ) )
                {
                    Flash::set("Codes created!" );
                    return redirect('codeBatchController/index');
                }

                Flash::set("Unable to create codes" , 'danger');
                return request()->return();
            }

            $data = [
                'title' => 'Universal Code'
            ];

            return $this->view('universal_code/create' , $data);
        }

        public function show($id) {
            $qr = $this->universal_code_model->dbget($id);
            $req =  request()->inputs();

            $data = [
                'whoIs' => whoIs(),
                'qr'     => $qr
            ];
            
            if(isset($req['share']) && $req['share'] == 'image') {
                /**
                 * create new image using user owned qr
                 * */
                $url = URL."/RaffleRegistrationController/register/?owned_qr={$qr->id}";
                $code = $qr->code;
                //create image if not exists
                $qrImageName = 'QR_RAFFLE_'.$code;
                if(!file_exists(PUBLIC_ROOT.DS.'tmp_uploads')) {
                    mkdir(PUBLIC_ROOT.DS.'tmp_uploads');
                }
                if(!file_exists(PUBLIC_ROOT.DS.'tmp_uploads'.DS.$qrImageName)) {
                    $retVal = QRTokenService::createQRImage([
                        'name' => $qrImageName,
                        'path' => PUBLIC_ROOT.DS.'tmp_uploads',
                        'srcURL' => URL.DS.'tmp_uploads',
                        'code'  => seal($url)
                    ]);
                }

                $data['imageSRC'] =  URL.DS.'tmp_uploads'.DS.$qrImageName.'.png';
            }

            return $this->view('universal_code/show' , $data);
        }
    }