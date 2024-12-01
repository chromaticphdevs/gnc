--ecommerce schema

create database aseanways_omg;

--stores schema

create table stores(
	id int(10) not null primary key auto_increment ,
	owner_id int(10) not null ,
	store_name varchar(50) not null,
	slug  varchar(50) not null,
	tagline varchar(50) not null ,
	wallpaper text ,
	logo text, 
	address text,
	facebook_page text,
	website text,
	created_at timestamp default now()
);


-- stores Indexes owner_id

--products schema
create table products(
	id int(10) not null primary key auto_increment ,
	store_id int(10) not null ,
	name varchar(50) not null ,
	image text ,
	price decimal(10 , 2) not null ,
	package_quantity int(10) not null,
	drc_amount decimal(10 , 2) not null ,
	unilvl_amount  decimal(10 , 2) not null ,
	is_visilble boolean default true ,
	description text
);

alter table add column com_distribution smallint default 10;
--products indexes store_id

--cart schema

create table carts(
	id int (10) not null primary key auto_increment , 
	token varchar(100) not null ,
	user_id int(10) not null ,
	dt timestamp default now ()
);

--cart item schema
create table cart_items(
	id int (10) not null primary key auto_increment,
	cart_id int(10) not null ,
	product_id int(10) not null ,
	quantity int(10) not null comment 'Defines the quantity of being purchase item specifically'
);

--orders


create table orders(
	id int(10) not null primary key auto_increment ,
	track_no varchar(15) not null comment 'Order tracker year-m-random+previousID',
	user_id int(10) not null ,
	address varchar(150) not null
); 
--alters
alter table orders add column payment_method enum('ewallet' , 'bank' , 'remittance') not null after track_no

alter table orders add column o_status enum('pending' , 'accepted' , 'declined') not null after track_no

create table order_items(
	id int(10) not null primary key auto_increment ,
	order_id int(10) not null ,
	product_id int(10) not null,
	price decimal(10 ,2) not null,
	quantity int(10) not null,
	total decimal(10 , 2) not null
); 

--binary pv commission
--table name has been altered to binary_pvs (binary points values)
create table binary_pv_commission(
	id int(10) not null primary key auto_increment ,
	c_id int(10) not null comment 'Desc: Commissioner id',
	fu_id int(10) not null comment 'Desc: from user id',
	pos_lr enum('left' ,'right') not null comment 'Downline position',
	points decimal(10, 2) not null comment 'points given',
	dt timestamp default now()
);


create table comission_deductions(
	id int(10) not null primary key auto_increment ,
	user_id int(10) not null ,
	deductor enum('payout' , 'system_err' , 'others') default 'payout',
	amount decimal(10 , 2) not null,
	dt timestamp default now()
);
---comissions

create table commissions(
	id int(10) not null primary key auto_increment ,
	type enum('DRC' , 'UNILVL') not null ,
	c_id int(10) not null comment 'Desc: Commissioner id' ,
	fu_id int(10) not null comment 'Desc: from user id',
	amount decimal(10 , 2) not null ,
	dt timestamp default now()
);


ALTER TABLE `aseanways_omg`.`comissions` RENAME TO `aseanways_omg`.`commissions`;

-- new schema for binary_volume commission
create table binary_pv_commissions(

	id int(10) not null primary key auto_increment ,
	user_id int(10) not null ,
	left_volume decimal(10 ,2) default 0,
	right_volume decimal(10 ,2) default 0,
	left_carry decimal(10 ,2) default 0,
	right_carry decimal(10 ,2) default 0,
	pair int(10) default 0 ,
	amount decimal(10 , 2) default 0,
	dt timestamp default now()

);

--create 

create table max_pair(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null ,
	max_pair int(10) default 10
);

--fill max_pair table

INSERT INTO max_pair ( user_id )
	SELECT id from users

--create table binary-points-deduction
create table binary_pv_deduction(
	id int(10) not null primary key auto_increment , 
	user_id int(10) not null ,
	points decimal(10 , 2) ,
	category enum('pair' , 'others') default 'pair',

	dt timestamp default now()

);

create table binary_pvs_pair_counter(
	id int(10) not null primary key auto_increment ,

)




-- new tables for computing commission

create table binary_pvs(
	id int(10) not null primary key auto_increment ,
	c_id int(10) not null comment 'Desc: Commissioner id',
	fu_id int(10) not null comment 'Desc: from user id',
	pos_lr enum('left' ,'right') not null comment 'Downline position',
	points decimal(10, 2) not null comment 'points given',
	dt timestamp default now()
);

create table binary_pv_commissions(

	id int(10) not null primary key auto_increment ,
	user_id int(10) not null ,
	binary_pvs_id int(10) not null comment 'parsed on this binary_pvs insert',
	left_volume decimal(10 ,2) default 0,
	right_volume decimal(10 ,2) default 0,
	left_carry decimal(10 ,2) default 0,
	right_carry decimal(10 ,2) default 0,
	pair int(10) default 0 ,
	amount decimal(10 , 2) default 0,
	dt timestamp default now()

);

create table binary_pv_pair_counter(
	id int(10) not null primary key auto_increment ,
	pair int(10) not null,
	binary_pv_com_id int(10) comment 'count parsed on this binaray_pv_commission id',
	user_id int(10) not null comment 'used to eliminate joining',
	dt timestamp default now()
);

create table binary_pv_pair_deduction(
	id int(10) not null primary key auto_increment ,
	binary_pv_com_id int(10) comment 'point deduction parsed on this binaray_pv_commission id',
	points decimal(10 ,2),
	dt timestamp default now()
);

DROP TABLE IF EXISTS `wallet_withdrawals`;
create table wallet_withdrawals(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null ,
	amount decimal(10 ,2) not null ,
	date timestamp default now()
);

/*PAYOUTS*/

create table payouts(
	id int(10) not null primary key auto_increment,
	created_on date ,
	date_from date not null ,
	date_to date not null,
	status enum('released' , 'pending')
)

create table payout_cheque(
	id int(10) not null primary key auto_increment,
	payout_id int(10) not null ,
	user_id int(10) not null,
	amount decimal(10, 2)  not null,
	status enum('recieved' , 'pending')
);

DROP TABLE IF EXISTS comission_deductions;

CREATE TABLE `comission_deductions` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL,
 `deductor` enum('payout','system_err','others') DEFAULT 'payout',
 `amount` decimal(10,2) DEFAULT NULL,
 `com_type` enum('DRC','UNILVL') NOT NULL,
 `dt` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1401 DEFAULT CHARSET=latin1
