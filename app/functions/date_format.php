<?php 	

	// function mk_time()/

	function date_long($date)
	{
		echo date('Y-M-d' , strtotime($date));
	}
	
	function get_date($date , $format = 'Y-m-d')
	{
		return date($format , strtotime($date));
	}
	function time_long($time)
	{
		echo date('h:i A' , strtotime($time));
	}
	function getTime(){

		return date('h:i:s a');
	}


	function today()
	{
		return date('Y-m-d H:i:s');
	}
	function getDay()
	{
		return date('D');
	}
	function getDateBefore()
	{	
		$dateToday = date('Y-m-d');	
		return date('Y/m/d H:i:s A',strtotime("-1 days {$dateToday}"));
	}


	function getPastDate($period)
	{
		$now = time(); // or your date as well
        $your_date = strtotime($period);
        $datediff = $now - $your_date;

        echo round($datediff / (60 * 60 * 24));
	}

	function convertNumericDay($day)
	{
		$dayList = [
			'Mon',
			'Tue',
			'Wed',
			'Thu',
			'Fri',
			'Sat',
			'Sun'
		];

		return $dayList[$day];
	}
	function dayNumericToLong($index)
	{
		return dayLong($index);
	}

	function dayNumericToShort($index)
	{
		return dayShort($index);
	}

	function dayShorToNumeric()
	{

	}

	function dayShortToLong()
	{

	}

	function dayLongToNumeric()
	{

	}

	function dayLongToShort()
	{

	}


	function dayLong($index){

		$longList = [
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Sunday'
		];

		return $longList[$index];
	}

	function dayShort($index){

		$longList = [
			'Mon',
			'Tue',
			'Wed',
			'Thu',
			'Fri',
			'Sat',
			'Sun'
		];

		return $longList[$index];
	}

	function dayNumeric($index)
	{

	}

	function getDayMonthOccurence($month , $day = 'Mon' , $year = null)
	{
		if(is_null($year)){
			$year = date('Y');
		}
		
		$dates = array();

		for($i=1; $i<30; $i++)
		  {
		    // echo '<br>',
		    $ddd = $year.'-'.$month.'-'.$i;
		    // echo '',
		    $date = date('Y M D d', $time = strtotime($ddd) );

		    if( strpos($date, $day) )
		    {
		      array_push($dates, $date);
		    }
		  }
		  return $dates;
	}
  

  	function getDatesOfMonth($month , $year = null)
  	{
  		if($year == null) {
  			//current year
  			$year = date('Y');
  		}

	  	$list=array();

		for($d=1; $d<=31; $d++)
		{
		    $time = mktime(12, 0, 0, $month, $d, $year);    

		    if (date('m', $time) ==$month)       
	        // $list[]=date('Y-m-d-D', $time);
	    	$list[]= date('Y M D d', $time );
		}

		return $list;
  	}
	
	function minutesToHours($minutes)
	{
		$hours = floor($minutes / 60) ;

		$remainingMinutes = $minutes % 60;

		return "{$hours} Hrs {$remainingMinutes} mins";
	}

	function timeDifference($date1 , $date2)
    {
    	$starttimestamp = strtotime($date1);
		$endtimestamp   = strtotime($date2);
		$difference     = abs($endtimestamp - $starttimestamp)/3600;

		return $difference;
	}
	
	function timeDifferenceInMinutes($startime , $endtime)
	{
		$time_in   = date_create($startime);
		$time_out  = date_create($endtime);
		$time_diff = date_diff($time_in,$time_out);


		$hour    = (int) $time_diff->format('%h');
		$minutes = (int) $time_diff->format('%i');

		if($hour)
			$hour = floor($hour * 60);

		return $hour + $minutes;
	}

	function time_since($date) {
		$timestamp = strtotime($date);

		$strTime = array("second", "minute", "hour", "day", "month", "year");
		$length = array("60","60","24","30","12","10");

		$currentTime = time();
		if($currentTime >= $timestamp) {
		   $diff     = time()- $timestamp;
		   for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
		   $diff = $diff / $length[$i];
		   }

		   $diff = round($diff);
		   return $diff . " " . $strTime[$i] . "(s) ago ";
		}
   }

   function date_compare($start , $end)
	{
		$date1 = date_create($start);
		$date2 = date_create($end);
		$diff = date_diff($date1,$date2);

		return [
			'days' => $diff->format('%a')
		];
	}

	/**
	 * if start is lesser than 
	 * compare date return negative int
	 */
	function date_difference_by_day($datestart, $datecompare) {
		$isLessThanCompare = false;

		if($datestart < $datecompare) {
			$isLessThanCompare = true;
		}
		
		$dateCompare = date_compare($datestart, $datecompare);
		$dateComparisonDays = $dateCompare['days'];
		
		return $isLessThanCompare ? intval(-1 * $dateComparisonDays) : intval($dateComparisonDays);
	}


//    function date_compare($date1, $date2) {
// 	$diff = abs(strtotime($date2) - strtotime($date1));

// 	$years = floor($diff / (365*60*60*24));
// 	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
// 	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

// 	return [
// 		'years' => $years,
// 		'months' => $months,
// 		'days' => $days,
// 	];
// }