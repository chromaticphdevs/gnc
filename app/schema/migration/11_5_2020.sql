alter table payout_request
	add column amount decimal(10 , 2);



drop table bank_pera_accounts;
create table bank_pera_accounts(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null,
	api_key varchar(50),
	api_secret varchar(50),
	account_number varchar(15),
	created_at timestamp default now(),
	updated_at datetime default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);




drop table bank_transfer_logs;

create table bank_transfer_logs(
	id int(10) not null primary key auto_increment,
	control_number varchar(12),
	user_id int(10) not null,
	approved_by int(10) not null,
	description text,
	created_at timestamp default now(),
	updated_at datetime default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);