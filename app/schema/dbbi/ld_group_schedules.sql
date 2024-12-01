--feb 7

drop table if exists ld_group_schedules;
create table ld_group_schedules(
	id int(10) not null auto_increment primary key ,
	groupid int(10) not null,
	date date ,
	time time ,
	grace_time char(20), 
	is_active boolean default true,
	status enum('pending' , 'active' , 'finished') default 'pending',
	created_at timestamp default now()
);