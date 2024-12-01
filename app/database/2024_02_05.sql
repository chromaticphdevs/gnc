drop table if exists cash_advance_releases;
CREATE table cash_advance_releases (
	id int(10) not null primary key auto_increment,
	release_reference varchar(50) unique,
	ca_id int(10) not null,
	user_id int(10) not null,
	amount decimal(10,2),
	entry_date datetime,
	external_reference varchar(50),
	account_no varchar(50),
	account_name varchar(50),
	org_id int(10),
	created_by int(10),
	image_proof text,
	created_at timestamp default now()
);

drop table if exists cash_advance_payments;
CREATE TABLE cash_advance_payments(
	id int(10) not null primary key auto_increment,
	payment_reference varchar(50) unique,
	ca_id int(10) not null,
	payer_id int(10) not null,
	amount decimal(10,2) not null,
	running_balance decimal(10,2),
	ending_balance decimal(10,2),
	entry_date date,
	external_reference varchar(50),
	account_no varchar(50),
	account_name varchar(50),
	org_id int(10),
	created_by int(10),
	image_proof text,
	created_at timestamp default now()
);

alter table fn_cash_advances add column balance decimal(10,2);