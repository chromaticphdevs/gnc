<?php
    #################################################
    ##         CORE CONFIGS                        ##
    #################################################

    define('PATH_UPLOAD' , BASE_DIR.DS.'public/uploads');
	define('GET_PATH_UPLOAD' , URL.DS.'public/uploads');
	define('PATH_PUBLIC' ,URL.DS.'public');
	define('PATH_TMP' , PATH_PUBLIC.DS.'tmp');
	define('PATH_VENDOR' , BASE_DIR.DS.'public/vendor');

    #################################################
	##             THIRD-PARTY APPS                ##
    #################################################

    define('DEFAULT_REPLY_TO' , '');

    const MAILER_AUTH = [
        'username' => '',
        'password' => '',
        'host'     => '',
        'name'     => '',
        'replyTo'  => '',
        'replyToName' => ''
    ];


    define('ITEXMO', 'ST-BREAK884834_MERSX');
	define('ITEXMO_PASS', 'wy!6#z6h5y');
    

	#################################################
	##             SYSTEM CONFIG                ##
    #################################################


    define('GLOBALS' , APPROOT.DS.'classes/globals');

    define('SITE_NAME' , 'gnc-e.com');

    define('COMPANY_NAME' , 'gnc-e');

    define('COMPANY_NAME_ABBR', 'General Network Corporation');
    define('COMPANY_EMAIL', '');
    define('COMPANY_TEL', '');
    define('COMPANY_ADDRESS', '');
    define('APP_NAME', 'General Network Corporation');

    define('KEY_WORDS' , '');
    define('DESCRIPTION' , '#############');
    define('AUTHOR' , 'General Network Corporation');
    define('APP_KEY' , '');


    const HEADING_META = [
        'keywords' => 'General Network Corporation, Corporation, Loan, Cash, Cash Advance',
        'description' => '',
        'og:type' => 'web',
        'og:url' => URL,
        'og:title' => 'Easy Loan, General Network Corporation',
        'og:description' => 'Easy Loan, General Network Corporation',
        'og:image' => URL.'/public/uploads/banner.jpg',
        'favicon' => URL.'/public/uploads/favicon.jpg',
        'author' => 'General Network Corporation'
    ];

    const COMPANY_DETAILS = [
        'name' => 'General Network Corporation',
        'description' => 'Helping people financial needs',
        'logo' => 'https://breakthrough-e.com/public/uploads/logo-circle.png',
        'address' => 'acro residence, tabang guiguinto bulacan'
    ];

    const THIRD_PARTY = [
        'pera' => [
            'business_auth' => [
                'key' => 'E528786B961474102C2F',
                'secret' => 'F0CBC40C007B5D969AD7'
            ]
		],

		'phpmailer' => [
			'host' => 'breakthrough-e.com',
            'username' => 'info@breakthrough-e.com',
            'password' => 'Q5nQF{sEo1mF',
            'name' => SITE_NAME,
            'replyTo' => 'info@breakthrough-e.com',
            'replyToName' => SITE_NAME,
		]
    ];
    
    /**
     * ENCODER A HAS ACCESS TO PAYMENTS
     * ONLY
     */
    const USER_TYPES = [
        'ADMIN'  => 1,
        'MEMBER' => 2,
        'ENCODER_A' => 3
    ];

    /**
     * loan charges
     */
    const LOAN_CHARGES = [
        'SERVICE_FEE_RATE' => 0.05,
        'ATTORNEES_FEE_RATE' => 0.10,
        'LOAN_INTEREST_FEE_RATE' => 0.05,
        'LATE_PAYMENT_ATTORNEES_FEE_AMOUNT' => 100
    ];

    const LOAN_ATTRIBUTES = [
        'ATTORNEES_FEE_ABBR' => 'ATTR_FEE',
        'ATTORNEES_FEE' => 'ATTORNEES FEE',
    ];

    const PAGE_AUTO_FOCUS = [
        'UPLOAD_ID_PAGE' => 'UPLOAD_ID_PAGE',
        'REFERRAL_PAGE' => 'REFERRAL_PAGE',
        'BANK_DETAIL_PAGE' => 'BANK_DETAIL_PAGE',
        'CASH_ADVANCE_PAGE' => 'CASH_ADVANCE_PAGE',
    ];
    
    const LEDGER_SOURCES = [
        'CASH_ADVANCE_LEDGER' => 'CASH_ADVANCE_LEDGER',
        'MEMBER_ACCOUNT_LEDGER' => 'MEMBER_ACCOUNT_LEDGER'
    ];

    const LEDGER_CATEGORIES = [
        'PENALTY_ATTORNEES_FEE' => 'PENALTY_ATTORNEES_FEE',
        'PAYMENT' => 'PAYMENT',
        'CASH_ADVANCE' => 'CASH_ADVANCE',
    ];
?>
