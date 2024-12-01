
update table 
	fn_cash_advances

	update created_on = created_on

		WHERE id




UPDATE table fn_cash_advances
	set created_on = (
		SELECT created_on 
			FROM fn_cash_advances
	)


UPDATE table fn_cash_advances
	set created_on = 

	LEFT JOIN 
	SELECT created_on , user_id
		FROM fn_cash_advances
		WHERE status != 'pending';


	WHERE status != 'pending';


ALTER TABLE fn_cash_advances
     CHANGE created_on
            created_on TIMESTAMP DEFAULT now();

ALTER TABLE fn_cash_advances
	add column updated_at TIMESTAMP DEFAULT now() 
		ON UPDATE now()



alter table user_addresses 
	add column type varchar(30)