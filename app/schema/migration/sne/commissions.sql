
DROP TABLE IF EXISTS commission_transactions;
CREATE TABLE commission_transactions(
	id int(10) not null primary key auto_increment,
	userid int(10) not null ,
	type char(20) ,
	amount decimal(10 , 0) ,
	date date ,
	origin enum('sne' , 'dbbi'),
	created_at timestamp default now()
);


/*migrate code*/

--binary commissions
	INSERT INTO commission_transactions(
		userid , type , amount , date , origin
	)SELECT user_id ,'binary' ,amount , dt , 'sne' from binary_pv_commissions
--commissions
	INSERT INTO commission_transactions(
		userid , type , amount , date , origin
	)

	SELECT c_id , 
	case when type = 'unilvl' then 'unilevel'
	else type end as type
	,	amount , dt , 'sne'

	from commissions where amount != 0 and c_id != 0;

/*create transaction tracker that will tracked down commissions and activation codes used by user*/

CREATE TABLE activation_transactions(
	id int(10) not null primary key auto_increment,
	userid int(10) not null primary key auto_increment ,
	activation_id ,

	...activation information
);



CREATE TABLE mg_payouts(
	id int(10) not null primary key auto_increment ,
	userid int(10) not null,
	datestart timestamp , 
	dateend timestamp ,
	status char(20)
);

drop table mg_payouts_items;


CREATE TABLE mg_payout_items(
	id int(10) not null primary key auto_increment ,
	payoutid int(10) not null,
	userid int(10) not null,
	amount decimal(10 ,2) ,
	status char(20) ,
	created_at timestamp default now()
);