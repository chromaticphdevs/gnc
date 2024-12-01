<?php 	

	class DatabaseInsert extends Controller
	{


		public function __construct()
		{
			$int = 15;

			$query = '';

			for($i = 2 ; $i <= $int ; $i++) 
			{
				$query .= "
					insert into users(
						firstname , lastname , username , password , direct_sponsor , upline ,
						status , max_pair , is_activated
					)

					VALUES('txt{$i}','txt{$i}','txt{$i}','$2y$10$/5j0HJFFMYMYVEGcA7zJ.uxD.19iJAlU2vcJSixRKXQWFLWbJqk1S' ,
					'11988' , '0' , 'starter' , '10' , '0');
				";

				$query .= '<hr/>';
			}


			echo $query;

		}


		public function index()
		{

		}
	}