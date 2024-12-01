<?php 	
	class Hustler extends Controller
	{
		public function index()
		{

		}
	}

	SELECT * FROM table
WHERE exec_datetime BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();


 select sum(amount) , count(id) 
 	FROM fn_product_release  
 	WHERE status = 'approved' 
 	AND date_time between  date_sub(now() , INTERVAL 30 DAY) AND now();


 	select sum(amount) , count(id) 
 	FROM fn_product_release 
 	WHERE status = 'Approved' 
 	AND DATEDIFF(CAST('2020-09-09' as DATE), DATE(date_time)) > 30