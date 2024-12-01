drop table if exists ld_device_tokens;
create table ld_device_tokens(
	id int(10) not null primary key auto_increment,
	code varchar(50) not null,
	token text ,
	is_used boolean default false,
	created_at timestamp default now()
);

drop table if exists ld_devices;
create table ld_devices(
	id int(10) not null primary key auto_increment,
	tokenid int(10) not null,
	token text
);



update users set status = 'pre-activated' 
	, max_pair = '10' is_activated = false

	WHERE userid > 22 and !> 191 and oldid != null