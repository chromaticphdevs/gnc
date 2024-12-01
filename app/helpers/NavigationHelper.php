<?php 

    class NavigationHelper{
        
        public $navs = [];
        public $navigationCount = 0;
        public function __construct()
        {
            // $this->moduleRestrict();
            $this->loadNavs();
        }

        public function getNavsHTML() {
            $navs = $this->navs;
            $retValHTML = '';
            if(!empty($navs)) {
                foreach($navs as $navGroupName => $navGroups) {
                    $retValHTML .= "<div class='sidebar-heading'>{$navGroupName}</div>";
                    foreach($navGroups as $navItem) {
                        if(isset($navItem['items'])) {
                            $navItems = $navItem['items'];
                            $navItemsHTML = '';
                            foreach($navItems as $navItemKey => $navItemRow) {
                                $attributes = $navItemRow['attributes'];
                                $icon = empty($navItemRow['icon']) ? 'fas fa-fw fa-tachometer-alt': $navItemRow['icon'];
                                $navItemsHTML .= <<<EOF
                                    <li class='nav-item'>
                                        <a class ='dropdown-item pb-0' href='{$navItemRow['url']}'>
                                            <i class='{$icon}'></i>
                                            <span>{$navItemRow['label']}</span>
                                        </a>
                                    </li>
                                EOF;
                            }
                            $icon = empty($navItem['icon']) ? 'fas fa-fw fa-tachometer-alt': $navItem['icon'];
                            $retValHTML .= <<<EOF
                                <li class='nav-item'>
                                    <div class="dropdown">
                                        <a class="nav-link pb-0 dropdown-toggle" 
                                            data-toggle="dropdown" href="#"><i class='{$icon}'></i><span>{$navItem['label']}</span></a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="background:#243954">            
                                            {$navItemsHTML}
                                        </ul>
                                    </div>   
                                </li>
                            EOF;
                        } else {
                            $attributes = $navItem['attributes'];
                            $icon = empty($attributes['icon']) ? 'fas fa-fw fa-tachometer-alt': $attributes['icon'];
                            $retValHTML .= "<li class='nav-item'>
                                <a class ='nav-link pb-0' href='{$navItem['url']}'>
                                    <i class='{$icon}'></i>
                                    <span>{$navItem['label']}</span>
                                </a>
                            </li>";   
                        }
                    }

                    $retValHTML .= "<hr class='sidebar-divider mt-3'>";
                }
            }
            return $retValHTML;
        }
        

        public function loadNavs() {
            $whoIs = whoIs();

            if($whoIs) {
                $moduleGroup = $this->moduleGroup();
                foreach($moduleGroup as $modKey => $modRow) {
                    $modRowItems = $modRow['items'];
                    foreach($modRowItems as $itemKey => $itemVal) {
                        if(is_array($itemVal)) {
                            $groupLabel = $itemVal['groupLabel'];
                            $groupLabelArray = explode('|', $groupLabel);

                            foreach($itemVal['items'] as $itemValKey => $itemValRow) {
                                $regExp = explode('|', $itemValRow);
                                $url = _route("{$regExp[0]}:{$regExp[1]}");
                                $icon = $regExp[3] ?? '';

                                $this->addNavigation($modKey, $regExp[2], $url, [
                                    'icon' => $icon
                                ], [
                                    'label' => $groupLabelArray[0],
                                    'icon'  => $groupLabelArray[1],
                                    'key'   => $itemKey
                                ]);
                            }
                        } else {
                            $regExp = explode('|', $itemVal);
                            $url = _route("{$regExp[0]}:{$regExp[1]}");
                            $icon = $regExp[3] ?? '';

                            $this->addNavigation($modKey, $regExp[2], $url, [
                                'icon' => $icon
                            ]);
                        }
                    }
                }
            }
        }

        private function moduleRestrict() {
            $whoIs = whoIs();

            if($whoIs) {
                $userTypeAccess = $this->userModuleAccess();
                $modelGroup = $this->moduleGroup();

                if($userAccess = $userTypeAccess[strtolower($whoIs['type'])]) {
                    foreach($userAccess as $key => $row) {
                        foreach($modelGroup as $modKey => $modRow) {
                            $modRowItems = $modRow['items'];
                            foreach($modRowItems as $itemKey => $itemVal) {
                                $regExp = explode('|', $itemVal);
                                $url = _route("{$regExp[0]}:{$regExp[1]}");
                                $icon = $regExp[3] ?? '';

                                if(isEqual($key, $regExp[0])) {
                                    $this->addNavigation($modKey, $regExp[2], $url, [
                                        'icon' => $icon
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }


        public function userModuleAccess() {
            $access = [
                'admin' => [
                    'dashboard' => '*',
                    'user' => '*',
                    'attendance' => '*',
                    'position' => '*',
                    'department' => '*',
                    'admin-shift' => '*',
                    'report' => '*'
                ],

                'super-admin' => [
                    'dashboard' => '*',
                    'user' => 'view',
                    'attendance' => '*',
                    'position' => 'view',
                    'department' => 'view',
                    'admin-shift' => 'view',
                    'report' => '*'
                ],
                
                
                'manager' => [
                    'dashboard' => '*',
                    'user' => 'view',
                    'attendance' => '*',
                    'position' => 'view',
                    'department' => 'view',
                    'admin-shift' => 'view',
                    'payroll' => 'view'
                ],

                'payroll' => [
                    'dashboard' => '*',
                    'payroll' => '*',
                    'deduction' => '*',
                ],

                'hr' => [
                    'dashboard' => '*',
                    'leave' => '*',
                    'leave-point' => '*',
                    'attendance' => '*',
                    'holiday'    => '*',
                    'recruitment' => '*',
                    'user' => '*',
                    'report' => '*'
                ],

                'regular_employee' => [
                    'dashboard' => '*',
                    'payslip' => '*',
                    'attendance' => '*',
                    'leave' => '*'
                ],
            ];

            return $access;
        }

        public function moduleGroup() {
            $accessType = whoIs('type');
            $items = $this->moduleAccess($accessType);

            return [
                'main' => [
                    'label' => 'Main',
                    'items' => $items
                ],
            ];
        }

        private function moduleAccess($userType) {
            $userId = seal(whoIs('id'));
            switch($userType) {
                case USER_TYPES['ENCODER_A']:
                    return[
                        'CashAdvancePaymentController|search|Payments|fa fa-money-bill-wave',
                        'TimekeepingController|index|Timekeeping|fa fa-clock',
                        'CashAdvanceReleaseController|activeSummaryLoan|Loan Summary|fa fa-info',
                        'account|searchUser|Search',
                    ];
                break;

                case USER_TYPES['MEMBER']:
                    return $this->memberLink();
                break;

                case USER_TYPES['ADMIN']:
                    return [
                        // 'admin|index|Dashboard|fas fa-fw fa-tachometer-alt',
                        [
                            'groupLabel' => 'Cash Advance|fa fa-money-bill-wave',
                            'items' => [
                                'FNCashAdvance|index|Requests',
                                'CashAdvanceReleaseController|index|Released',
                                'CashAdvancePaymentController|search|Payments',
                                'CashAdvanceReleaseController|byPassLoanAndRelease|Bypass process',
                                'CashAdvanceReleaseController|pastdue|Pastdues',
                                'CashAdvanceReleaseController|penalty|Penalties',
                            ]
                        ],
                        'CashAdvanceReleaseController|activeSummaryLoan|Loan Summary|fa fa-info-circle',
                        'UserIdVerification|verify_id_list|ID Verification|fa fa-check-circle',
                        [
                            'groupLabel' => 'Accounts|fa fa-users',
                            'items' => [
                                'account|list|List',
                                'account|searchUser|Search'
                            ]
                        ],
                        'Geneology|binary|Geneology|fa fa-geneology',
                        'UserSocialMedia|index| Social Media |fa fa-user-check',
                        'ChatGroupController|index|Chat|fa fa-paper-plane',
                        'TimekeepingController|index|Timekeeping|fa fa-clock',
                    ];
                break;
            }
        }


        public function addNavigationBulk($menu, $navigations) {
            foreach($navigations as $key => $row) {
                $this->addNavigation($menu, $row[0], $row[1], $row[2] ?? []);
            }
        }

        public function addNavigation($menu, $label, $url, $attributes = [], $linkGroup = null) {
            if(!isset($this->navs[$menu])) {
                $this->navs[$menu] = [];
            }

            if(!is_null($linkGroup)) {
                $key = $linkGroup['key'];

                if(!isset($this->navs[$menu][$this->navigationCount]['items'])) {
                    $this->navigationCount++;
                    $this->navs[$menu][$this->navigationCount] = [
                        'items' => [],
                        'key' => $key,
                        'label' => $linkGroup['label'],
                        'icon' => $linkGroup['icon']
                    ];
                }

                $this->navs[$menu][$this->navigationCount]['items'][] = $this->setNav($menu, $label, $url, $attributes, $linkGroup);
                
            } else {
                $this->navigationCount++;
                $this->navs[$menu][$this->navigationCount]= $this->setNav($menu, $label, $url, $attributes, $linkGroup);
            }
            
        }

        public function setNav($menu, $label, $url, $attributes = [], $linkGroup = null) {
            return [
                'label'      => $label,
                'url'        => $url,
                'attributes' => $attributes,
                'menu'       => $menu,
                'linkGroup'  => $linkGroup
            ];
        }

        public function otherAdminLinks() {
            return [
                
                [
                    'groupLabel' => 'Organizations|fa fa-sitemap',
                    'items' => [
                        'team|details|Team',
                        'team|details?level=5|5th',
                        'binaryGeneology|index|7th',
                        'UserDirectsponsor|index|Customers',
                        'team|regular-customers|Regular Customers',
                    ]
                ],
                'FinancialStatementController|index|Financial Statements|fa fa-money-bill-wave',
                'PettyCashController|index|Petty Cash|fa fa-money-bill-wave',
                'InventoryController|index|Inventory|fa fa-database',
                'CodeBatchController|index|UCodes|fa fa-dice-two',
                'LoanController|index|Loan|fa fa-money-bill-wave',
                'LoanUniversalController|index|ULoan|fa fa-money-bill-wave',
                'UserBinary|get_transactions|Team Transactions|fa fa-hourglass',
                [
                    'groupLabel' => 'Payout|fa fa-money-bill-wave',
                    'items' => [
                        'MGPayout2|create_payout|Generate',
                        'MGPayout2|create_payout_valid_id?amount=0|Generate Generate W/ Valid ID',
                        'MGPayout2|create_payout_valid_id?amount=1000|Generate W/ Valid ID Min 1000',
                        'MGPayout2|create_payout_valid_id?amount=1500|Generate W/ Valid ID Min 1500',
                        'MGPayout_Request|create_payout|Requests',
                        'PayoutRequest|index|Payout Requests',
                        'MGPayout2|list|History',
                    ]
                ],
                'MGPayout2|get_payins_with_option|Payins|fa fa-money-bill-wave',
            ];
        }

        private function memberLink() {
            $whoIs = whoIs(); 

            $retVal = [];

            $links = [
                'chat_group' => 'ChatGroupController|index|Chat|fa fa-paper-plane',
                'upload_id_page' => 'UserIdVerification|upload_id_html|Upload ID|fa fa-file-download',
                'referral_page' => 'UserDirectsponsor|index|'.WordLib::get('referrals'). '|fa fa-users',
                'bank_upload_page'  => 'UserBankController|index|Bank|fa fa-university',
                'cash_advance_page' => 'LoanController|requirements|Cash Advance|fa fa-money-bill-wave',
                'loan_processor_video_page' => 'LoanProcessorVideoController|index|Processed Loans|fa fa-money-bill-wave',
                'geneology' => 'Geneology|binary|Geneology|fa fa-tree'
            ];

            switch($whoIs['page_auto_focus']) {
                case PAGE_AUTO_FOCUS['UPLOAD_ID_PAGE']:
                    $retVal = [
                        $links['chat_group'],
                        $links['upload_id_page'],
                    ];
                break;

                case PAGE_AUTO_FOCUS['REFERRAL_PAGE']:
                    $retVal = [
                        $links['chat_group'],
                        $links['upload_id_page'],
                        $links['referral_page']
                    ];
                break;


                case PAGE_AUTO_FOCUS['BANK_DETAIL_PAGE']:
                    $retVal = [
                        $links['chat_group'],
                        $links['upload_id_page'],
                        $links['referral_page'],
                        $links['bank_upload_page'],
                    ];
                break;

                case PAGE_AUTO_FOCUS['CASH_ADVANCE_PAGE']:
                    $retVal = [
                        $links['chat_group'],
                        $links['upload_id_page'],
                        $links['referral_page'],
                        $links['bank_upload_page'],
                        $links['cash_advance_page'],
                        $links['loan_processor_video_page'],
                    ];

                    if(!isEqual(whoIs('status'), ['starter','bronze','pre-activated'])) {
                        array_push($retVal,$links['geneology']);
                    }
                break;

                default:
                    $retVal = $links;
            }

            return $retVal;
        }
    }