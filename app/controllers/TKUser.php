<?php 	

	class TkUser extends Controller
	{

		public function __construct()
		{
			$this->endpoint = 'https://app.breakthrough-e.com';

			// $this->endpoint = 'http://dev.bktktool';

			$this->tkapp = model('TimekeepingAppModel');
		}

		public function show($userToken)
		{
			$appUserData = $this->tkapp->apiGetByTokenComplete($userToken);

            $timesheets = $appUserData->timesheets;

            $wallets = $appUserData->wallets;
            
            $data = [
                'account' => $appUserData,
                'timesheets'  => $timesheets,
                'wallets'   => $wallets
            ];

            $parsed = [
            	'timesheetsGrouped' => [],
            	'pendingTimesheets' => 0 ,
            	'workHoursToday'    => 0,


            	'wallets' => [
            		'payout' => 0,
            		'payouts' => [], //limit 5
            	],

            	'walletsGrouped' => [] //limit 20
            ];

            $today = get_date( today() , 'M d Y');

            foreach($data['timesheets'] as $tk)
            {
            	$date = get_date($tk->created_at , 'M d Y');

            	if( !isset($parsed['timesheetsGrouped'][$date]) )
            		$parsed['timesheetsGrouped'][$date] = [];

            	if(isEqual($tk->status , 'pending'))
            		$parsed['pendingTimesheets']++;

            	if( isEqual($today , $date) ) 
            		$parsed['workHoursToday'] += floatval($tk->duration);

            	$parsed['timesheetsGrouped'][$date][] = $tk;
            }

            $parsed['workHoursToday'] = minutesToHours($parsed['workHoursToday']);

            $counter = 0;
            $payouts = 0;

            foreach($data['wallets'] as $wlt )
            {
            	$date = get_date($wlt->created_at , 'M d Y');

            	if( !isset($parsed['walletsGrouped'][$date]) )
            		$parsed['walletsGrouped'][$date] = [];

            	$parsed['walletsGrouped'][$date][] = $wlt;
            	
            	
            	if( $wlt->amount < 0 ) 
            	{
            		$parsed['wallets']['payout'] += floatval($wlt->amount);

        			if($payouts > 5)
        				continue;

        			$parsed['wallets']['payouts'] [] =  $wlt;
        			$payouts++;
        		}
            }

            $data['parsed'] = $parsed;

            $data['showAll'] = URL.DS.'timekeeping/getUser/'.$userToken;
            
            return $this->view('timekeeping/tk_user' , $data);
		}
	}