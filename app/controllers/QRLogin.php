<?php 
    use Services\{
        QRTokenService,
        QRLoginService
    };
    load(['QRTokenService', 'QRLoginService'], APPROOT.DS.'services');


    class QRLogin extends Controller
    {

        public function __construct()
        {
            $this->userModel = model('User_model');
            $this->userLogModel = model('UserLoggerModel');
            $this->qrLoginService = new QRLoginService();
        }

        public function index() {
            return $this->qrcodepicture();
        }
        public function getLatest(){
            ee($this->getTokenLatest());
        }
        
        public function login() {

            $request = request()->inputs();

            $user = false;
            $qrToken = false;
            
            if ($this->request() === 'POST') 
            {
                $lastOpenedLink = Session::get('QR_TOKEN_LOGIN');
                $lastOpenedLink = strtotime(today()) - strtotime($lastOpenedLink);

                if ($lastOpenedLink > 60) {
                    Flash::set("QR Code Expired", 'danger');
                    return redirect('QRLogin/qrcodepicture');
                }

                $username = filter_var($_POST['username']);
				$password = filter_var($_POST['password']);
				$res = $this->userModel->user_login($username, $password, [2,3]);
                
				//if there is result
				if ($res) {
					if (password_verify($password, $res->password)) {
                        //add login info
                        $result = $this->userLogModel->addQRLogin($res->id,$request['group_id']);

                        if(!$result) {
                            Flash::set($this->userLogModel->getErrorString(), 'danger');
                            return request()->return();
                        }
                        $this->createNewQR();
                        Flash::set("Log-in Successfully Recorded.");
                        $user = $res;
                    } else {
                        Flash::set("Incorrect Password" , 'danger');
                        return request()->return();
                    }
                } else {
                    Flash::set("user not found!");
                    return request()->return();
                }
            } else {
                Session::set('QR_TOKEN_LOGIN', today());
                if (!isset($request['token'])) {
                    $this->invalidQR();
                } else {
                    $qrToken = $this->getTokenLatest();
                    if(!isEqual($qrToken->token, $request['token'])) {
                        $this->invalidQR();
                    }
                }
            }

            return $this->view('qrlogin/login', [
                'qrToken' => $qrToken,
                'user' => $user,
                'groups' => $this->qrLoginService->getGroups()
            ]);
        }

        public function createNewQR() {
            QRTokenService::renewOrCreate('LOGIN_TOKEN');
        }

        private function invalidQR() {
            $html =  "<div style='width:400px; margin:0px auto; text-align:center; border: 1px solid #000; padding:10px'>";
                $html .= "<h1>INVALID QR</h1>";
                $html .= "<h2>Please scan the QR code again, this time be quick to login.</h2>";
            $html.= "</div>";
            echo $html;
            die();
        }

        public function qrcodepicture() {
            if (isset($_GET['token'])) {
                die();
            } else {
                return $this->view('qrlogin/qrpicture');
            }
        }

        private function getTokenLatest() {
            $qrToken = QRTokenService::getLatest(QRTokenService::LOGIN_TOKEN);
            $qrToken->full_path = base64_decode($qrToken->full_path);
            $qrToken->src_url = base64_decode($qrToken->src_url);
            $qrToken->qr_link = base64_decode($qrToken->qr_link);

            return $qrToken;
        }

        public function logs() {

            $logs = $this->userLogModel->getLogsToday();
            $logsToday = $this->userLogModel->getLogsToday('TODAY');

            $groupedByUsers = [];
            
            foreach($logs as $key => $row) {
                if(!isset($groupedByUsers[$row->username])) {
                    $groupedByUsers[$row->username] = [
                        'username'=> $row->username,
                        'logins' => [],
                        'total' => 0
                    ];
                }
                $groupedByUsers[$row->username]['logins'][] = $row;
                $groupedByUsers[$row->username]['total']++;
            }
            usort($groupedByUsers, function($a, $b) {
                if($a['total']==$b['total']) return 0;
                    return $a['total'] < $b['total']?1:-1;
            });

            $where = [
                'date(ull.date_time)' => date('Y-m-d', strtotime(today()))
            ];

            if (isset($_GET['log_filter'])) {
                $where = [
                    'date(ull.date_time)' => [
                        'condition' => 'between',
                        'value' => [
                            $_GET['start_date'], $_GET['end_date']
                        ]
                    ]
                ];
            }
            $this->loanModel = model('LoanModel');
            $qualifiers = $this->loanModel->getQualifierCreditors([
                'order' => 'ull.date_time desc',
                'where' => $where
            ]);

            usort($qualifiers, "uncommon_sort_qualifers");

            return $this->view('qrlogin/logs', [
                'qualifiers' => $qualifiers,
                'logs' => [
                    'today' => $logsToday,
                    'groupedByUsers' => $groupedByUsers
                ],
                'qrLoginService' => $this->qrLoginService
            ]);
        }
    }