
drop table csr_timesheets;
create table csr_timesheets(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null,
	customer_id int(10) not null,
	amount decimal(10 , 2) ,
	duration smallint,
	rate decimal(10 , 2),
	work_hours smallint,
	created_at timestamp default now() 
);


create table csr_accounts(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null,
	updated_at timestamp default now()
);


/*
*Commands for csr accounts 
*/
INSERT INTO csr_accounts( user_id )
	(SELECT id from users where status in('silver','gold','platinum','diamond'));