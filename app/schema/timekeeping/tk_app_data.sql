create table tk_app_data(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null,
	access_key varchar(100) not null,
	created_at timestamp default now()
);