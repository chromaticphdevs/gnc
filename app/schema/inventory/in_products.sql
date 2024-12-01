drop table in_products;
create table in_products(
    id int(10) not null primary key auto_increment,
    code varchar(12) not null comment 'product code',
    name varchar(100) not null comment 'product name',
    capital decimal(10 , 2),
    sell_price decimal(10 , 2),
    description text,
    image text,
    path_upload text,
    created_at timestamp default now()
);