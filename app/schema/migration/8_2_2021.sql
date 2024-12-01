/*
*acts as users_log
*you can add anything here
*about users transaction on the system
*/
drop table if exists user_meta;
create table usermetas(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null,
	meta_key varchar(100) ,
	meta_value text,
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
);