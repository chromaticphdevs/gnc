<?php
	require_once FNCTNS.DS.'crawler.php';
	
	class BinaryTest extends Controller
	{

		public function index()
		{

			$userid = 12372;
			$uplines = crawler_drc($userid,100);

			echo '<pre>';
				print_r($uplines);
			echo '</pre>';

			echo '<hr/>';
			echo $userid;
		}
	}