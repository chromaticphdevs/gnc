<?php 
    use Services\QRTokenService;
	load(['QRTokenService'],APPROOT.DS.'services');

    class WalletController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->commissionModel = model('CommissionTransactionModel');
            $this->userModel = model('User_model');
            $this->whoIs = whoIs();
            $this->totalAvailableEarning = $this->commissionModel->getAvailableEarning($this->whoIs['id'] ?? null);
        }

        public function index() {
            authRequired();

            $qrSource = QRTokenService::createWalletQR(seal(whoIs()['id']));

            $data = [
                'wallets' => $this->commissionModel->getAll([
                    'where' => [
                        'com.userid' => $this->whoIs['id'],
                        'com.type' => 'WALLET'
                    ]
                ]),
                'title' => 'Wallet Transactions',
                'availableEarning' => $this->totalAvailableEarning,
                'qrSource' => $qrSource
            ];

            return $this->view('wallet/express_index', $data);
        }

        public function expressSend() {
            $req = request()->inputs();

            if (isSubmitted()) {
                $result = $this->commissionModel->expressSend($req['recipient_username'], $req['userid'], $req['amount'], $req['notes']);
                if(!$result) {
                    Flash::set($this->commissionModel->getErrorString(), 'danger');
                    return request()->return();
                }

                Flash::set($this->commissionModel->getMessageString());
                return redirect('walletController/index');
            }
            
            $data = [
                'title' => 'Express send',
                'availableEarning' => $this->totalAvailableEarning,
                'whoIs' => $this->whoIs
            ];

            if(isset($req['via'],$req['token'])) 
            {
                $tokenUnsealed = unseal($req['token']);
                if(is_null($this->whoIs)) {
                    $lastPage = seal(get_cur_url());
                    //user must login-first to do express send
                    Flash::set("Login your account then continue sending wallet.");
                    return redirect('users/login?lastPage='.$lastPage.'&type=raw');
                } else {
                    $recipient = $this->userModel->get_user(unseal($tokenUnsealed['recipientId']));

                    if($recipient->id == $this->whoIs['id']) {
                        Flash::set("It is restricted to send wallet to same account.", 'danger');
                        return redirect('WalletController/expressSend');
                    }
                    //send dayon
                    $data['recipient_username'] = $recipient->username;
                    return $this->view('wallet/express_qr', $data);
                }
            }else {
                authRequired();
            }
            return $this->view('wallet/express_send', $data);
        }
    }