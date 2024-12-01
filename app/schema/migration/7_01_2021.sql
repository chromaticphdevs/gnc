drop table product_deliveries;
create table product_deliveries(
	id int(10) not null primary key auto_increment,
	reference varchar(20) not null,
	track_id int(10) not null comment ' release product id',
	full_name varchar(100) not null,
	mobile_number varchar(50),
	billing_address text,
	status enum('pending' , 'delivered' , 'cancelled' , 'returned') default 'pending',
	remarks text,
	created_by int(10) not null,
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE CURRENT_TIMESTAMP
);

drop table product_delivery_item_info;
create table product_delivery_item_info(
	id int(10) not null primary key auto_increment,
	delivery_id int(10) not null comment 'product deliveries fk',
	product_id int(10) not null,
	type enum('in_code_libraries' , 'fn_product_release') default 'in_code_libraries',
	item_name varchar(150),
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE CURRENT_TIMESTAMP
);
