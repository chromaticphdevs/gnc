<?php 	
	

	require_once FNCTNS.DS.'crawler.php';

	class DirectSponsorTest extends Controller
	{

		public function index()
		{
			$directSponsor = '12394';


			$directSponsorArray = crawler_drc($directSponsor);


			die(var_dump($directSponsorArray));

		}
	}