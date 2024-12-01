/*4/21/2020*/
alter table users add column middlename char(50) after firstname;

create table user_register_attempts(
    id int (10) not null primary key auto_increment,
    fullname varchar(100),
    email varchar(50),
    mobile char(11),
    created_at timestamp default now()
);