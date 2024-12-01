<?php 	

	class PHPCurl extends Controller
	{

		public function index()
		{
			$curl = curl_init();
			$url  = "https://www.lazada.com.ph/catalog/?q=business&_keyori=ss&from=input&spm=a2o4l.searchlist.search.go.539d2af8culbxl";

			/*connect to amazon*/

			curl_setopt($curl, CURLOPT_URL, $url);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, $url);

			curl_setopt($curl, CURLOPT_POST, 1);

			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			curl_exec($curl);
		}
	}