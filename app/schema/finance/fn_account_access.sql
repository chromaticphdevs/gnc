create table fn_accounts_access(
	id int(10) not null primary key auto_increment,
	access varchar(50),
	created_at timestamp default now()
);

INSERT INTO fn_accounts_access(
	access
)VALUES('Collector'),
('Verifier'),
('Cashier'),
('Stocks');