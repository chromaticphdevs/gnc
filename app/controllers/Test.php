<?php 	
	use Services\QRTokenService;
	load(['QRTokenService'],APPROOT.DS.'services');


	class Test extends Controller
	{		

		public function __construct()
		{
			parent::__construct();
		}

		public function index(){
			//generate qr code
			QRTokenService::createWalletQR(seal(whoIs()['id']));
			return $this->view('test/index');
		}
	}