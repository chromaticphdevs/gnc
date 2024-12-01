
drop table logistics_orders;

create table logistics_orders(
	id int(10) not null primary key auto_increment,
	type enum('product-release'  , 'order') default 'order',
	order_id int(10) not null,
	logistic_reference varchar(100) not null comment ' code comming from bk logistics ',
	remarks text,
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
);