create table in_stock_transactions(

    id int(10) not null primary key auto_increment,
    from_branch int(10) not null,
    to_branch int(10) not null,
    user_id int(10) not null comment 'user who commit the action',
    description text not null,
    created_at timestamp default now()
);