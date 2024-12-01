drop table if exists fn_accounts;
create table fn_accounts(
	id int(10) not null primary key auto_increment,
	branchid int(10) not null,
	name varchar(100),
	username char(25),
	password varchar(200),
	type enum('branch-manager','stock-manager' ,'cashier') not null,
	created_at timestamp default now()
);