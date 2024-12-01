drop table tk_data;
create table tk_data(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    secret_key varchar(50) not null unique,
    qrcode text
);