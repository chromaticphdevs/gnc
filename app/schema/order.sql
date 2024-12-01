

drop table if exists order_deliveries;

create table order_deliveries(
	id int(10) not null primary key auto_increment,
	orderid int(10) not null,
	control_number char(30) not null,
	image text,
	created_at timestamp default now()
);