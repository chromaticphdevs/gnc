drop table if exists fn_code_inventories;
create table fn_code_inventories(
	id int(10) not null primary key auto_increment,
	code varchar(100) not null,
	branchid int(10) not null,
	box_eq int(10) ,
	amount decimal(10 , 4) ,
	drc_amount decimal(10 , 4) ,
	unilevel_amount decimal(10 ,4),
	binary_point int(10),
	distribution smallint,
	level char(35),
	max_pair smallint,
	company char(35) not null,
	status enum('available' , 'released' , 'used' , 'expired'),
	created_at timestamp default now()
);

drop table if exists fn_off_code_inventories;
create table fn_off_code_inventories(
	id int(10) not null primary key auto_increment,
	codeid int(10) not null,
	userid int(10) not null,
	status enum('released','used' , 'expired'),
	created_at timestamp default now()
);

/*2/26/2020*/

drop table if exists fn_code_storage;
create table fn_code_storage(
	id int(10) not null primary key auto_increment,
	name varchar(100) not null,
	box_eq int(10),
	amount decimal(10 , 4) ,
	drc_amount decimal(10 , 4) ,
	unilevel_amount decimal(10 ,4),
	binary_point int(10),
	distribution smallint,
	level char(35),
	max_pair smallint,
	status enum('available' , 'released' , 'used' , 'expired'),
	created_at timestamp default now()
);
