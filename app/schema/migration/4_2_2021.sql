alter table user_profiling
	add column number_status enum('Cannot be reached' , 'Drop Call' , 
		'Ghost Call' , 'Dead Number' , 'Not Owned' , 'Good') default 'Good';

