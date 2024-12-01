--/2/10/2020 - DBBI 
--new table payin_transactions

--2/16/2020 - 


drop table if exists manager_accounts;

create table manager_accounts(
	id int(10) not null primary key auto_increment,
	type enum('branch-manager' , 'stock-manager' , 'cashier') not null,
	fullname varchar(100),
	username varchar(50) not null,
	password varchar(250) not null,
	branchid smallint,
	status enum('active' , 'disabled'),
	created_at timestamp default now()
);