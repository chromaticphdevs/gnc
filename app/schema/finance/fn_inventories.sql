drop table if exists fn_inventories;
create table fn_item_inventories(
	id int(10) not null primary key auto_increment,
	branchid int(10) not null,
	quantity int(10) comment 'negative or positive', 
	description text,
	created_at timestamp default now()
);


drop table if exists fn_single_box_loans;
create table fn_single_box_loans(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	code varchar(300) not null,
	amount decimal(10 ,4) not null,
	branchid int(10) not null,
	status enum('pending' ,'claimed' , 'paid')
);