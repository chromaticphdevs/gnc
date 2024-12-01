alter table users
    add column esig varchar(100);


drop table if exists user_banks;
create table user_banks(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    description varchar(100),
    organization_id int(10) comment 'foreign key from global_meta table',
    account_number varchar(50),
    account_name varchar(100),
    is_active boolean default true,
    created_at timestamp default now()
);

SELECT * FROM users where lastname  = 'Micaller' order by id desc;


SELECT * FROM users where username  = 'ChingG' order by id desc;
SELECT * FROM users where username  = 'JjManlapaz' order by id desc;
 

SELECT * FROM users where username  = 'thundermoves' order by id desc;

SELECT * FROM users where username  = 'datuonel' order by id desc;



update users 
    set email = concat('*','',email),
    mobile = concat('*','', mobile),
    username = concat('*', '', username),
    firstname = concat('*', '', firstname),
    lastname = concat('*', '', lastname)
    WHERE YEAR(created_at) < '2024'
        and email not in ('Edromero1472@yahoo.com','gonzalesmarkangeloph@gmail.com', 'patrickdeguzman1008@gmail.com');