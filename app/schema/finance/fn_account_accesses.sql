drop table fn_account_accesses;
create table fn_account_accesses(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null,
	access_id varchar(50),
	is_activated boolean default true
);


insert into fn_account_accesses(user_id  , access_id)
	VALUES(1 , 1),
	(1 , 2);