<?php 	

	class API_SendReferralLinkToSMS extends Controller
	{

		public function __construct()
		{

		}

		/*
		*pass userId
		*/
		public function send()
		{
			$userId = request()->input('userId');

			$getLinkParam = [
				null, //uplineid
				null, //directsponsorId
				null, //position
				$userId //userId
			];

			$link = getUserLink( ...$getLinkParam );

			return ee(api_response( $link ));
		}
	}