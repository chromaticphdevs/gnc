create table ca_qualified_users(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    verified_date datetime
);


create table dev_system_logs(
    id int(10) not null primary key auto_increment,
    result varchar(50),
    message text,
    created_at timestamp default now()
);
