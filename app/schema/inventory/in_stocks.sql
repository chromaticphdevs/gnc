create table in_stocks(
    id int(10) not null primary key auto_increment,
    branch_id int(10) not null,
    product_id int(10) not null,
    quantity int(10) ,
    description text,
    date_delivered date,
    created_at timestamp default now()
);