create table link_shortener(
    id int(10) not null primary key auto_increment,
    user_id int(10),
    shortened_key char(10) unique,
    redirect_link text,
    visitors tinyint,
    created_at timestamp default now(),
    updated_at timestamp default now() ON UPDATE now()
);


update fn_cash_advances
    set amount = 25000,
    net = (25000 + service_fee) + (25000 * .10),
    balance = (25000 + service_fee) + (25000 * .10)
    WHERE code = 'C20022024-488';


SELECT id,code,(25000 + service_fee) + (25000 * .10)  FROM fn_cash_advances
WHERE code = 'C20022024-488'
SELECT * FROM fn_cash_advances where code = 'C20022024-488';