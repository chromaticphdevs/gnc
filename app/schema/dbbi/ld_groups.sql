-- feb 7 

create table ld_groups(

	id int(10) not null primary key auto_increment,
	group_name char(50) , 
	branchid int(10) not null,
	is_active boolean default true,
	created_at timestamp default now()
);