--

drop table if exists single_box_advances;
create table single_box_advances(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	amount decimal(10 , 2) not null,
	code char(12) not null,
	status enum('pending' , 'claimed' , 'paid'),
	created_at timestamp default now()
);