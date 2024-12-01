drop table if exists fn_branches;

create table fn_branches(
	id int(10) not null primary key auto_increment,
	name varchar(100),
	address text,
	notes text,
	created_at timestamp default now()
);