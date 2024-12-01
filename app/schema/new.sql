create table user_emp_action_logs(
	id int(10) not null primary key auto_increment , 
	emp_logsid int(10) not null,
	action enum('timein' , 'timeout'),
	dt timestamp default now()
)

-- 10/2/2019
create table activated_users(
	id int(10) not null primary key auto_increment ,
	date_activated timestamp default now(),
	userid int(10) not null,
	status enum('active' , 'inactive')
);


-- update order process

alter table order_items
add column binary_total decimal(10 , 2 );

alter table order_items
add column drc_total decimal(10 , 2);

alter table order_items
add column unilvl_total decimal(10 ,2) after price;


alter table users drop column status;
alter table users add column status enum('pre-activated' , 'starter' ,
'bronze' , 'silver' , 'gold' , 'platinum' ,'diamond')

default 'pre-activated';

create table change_pwd_sessions(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	email varchar(100) not null,
	newpassword varchar(150) not null comment 'hashsed password transfer to userid',
	token varchar(150) not null,
	status enum('open' , 'closed')
);

/*Activation user update*/

drop table if exists activated_users;
create table activated_users(
	id int(10) not null primary key auto_increment ,
	date_activated timestamp default now(),
	userid int(10) not null,
	status enum('active' , 'inactive')
);


alter table activated_users drop column status;

alter table activated_users add column status enum('pre-activated' , 'starter' ,
'bronze' , 'silver' , 'gold' , 'platinum' ,'diamond');



/**10_16**/

create table payment_attachments(
	id int(10) not null primary key auto_increment,
	orderid int(10) not null ,
	filepath text,
	status enum('active' , 'inactive')
);


/*2019-10-23*/


/*this will veriffy if the product is already ready for the market place*/
alter table products add column verification enum('verified' , 'unverified') default 'unverified';

/*This will identify if the product is for verification or na*/
alter table products add column product_from enum('user' , 'admin');

ALTER TABLE `payouts` CHANGE `date_from` `date_from` DATETIME;
ALTER TABLE `payouts` CHANGE `date_to` `date_to` DATETIME;

alter table users add column mobile varchar(13) after email;
alter table users add column address varchar(200) after email;




/*dec 3*/

alter table products add column max_pair int(10) default 10;

alter table users add column max_pair int(10) default 0;


UPDATE table set direct_sponsor = (
	SELECT userid from old_table 
		WHERE userid = id
) WHERE id in(
	SELECT id from users 
		where direct_sponsor = 0
)

[1,2,3,4,5];

UPDATE users as u set direct_sponsor = (
	SELECT userid from old_table
		WHERE userid = u.id
)WHERE u.direct_sponsor = 0;



SELECT sum(amount) AS total 
FROM $this->table AS wallet
WHERE user_id = '$userId'


SELECT CONCAT(first_name , ' ' , last_name) as full_name , SUM(amount) AS total 
	FROM wallet_transactions as wt
	LEFT JOIN users as user 
	ON user.id = wt.user_id

	GROUP BY user.id

	ORDER BY SUM(amount) desc;