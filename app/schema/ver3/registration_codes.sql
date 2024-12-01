create table registration_codes(
    id int(10) not null primary key auto_increment,
    userid int(10),
    code char(4),
    is_used boolean default false,
    created_at timestamp default now()
);