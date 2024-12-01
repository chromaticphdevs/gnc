drop table if exists fn_cash_inventories;

create table fn_cash_inventories(
	id int(10) not null primary key auto_increment,
	branchid int(10) not null,
	amount decimal(10 , 2) not null,
	description text, 
	created_at timestamp default now()
);