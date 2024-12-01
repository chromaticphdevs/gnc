DROP TABLE IF EXISTS payin_transactions;
create table ld_payin_transactions(
	id int(10) not null primary key auto_increment,
	purchaser int(10) not null,
	amount int(10) not null,
	dateandtime timestamp default now(),
	type enum('code' , 'order'),
	origin enum('dbbi' , 'sne')
);