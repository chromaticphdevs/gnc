create table toc_passers(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    position smallint,
    is_paid boolean default false,
    created_at timestamp default now(),
    updated_at datetime default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


create table toc_passers_logs(
     id int(10) not null primary key auto_increment,
     user_id int(10) not null,
     remarks varchar(100),
     created_at timestamp default now()
);