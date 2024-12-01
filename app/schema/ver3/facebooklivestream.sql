/*4/3/2020*/

drop table if exists facebooklive_streams;

create table facebooklive_streams(
    id int(10) not null primary key auto_increment,
    userid int(10) not null,
    title varchar(100),
    stream_code varchar(100) unique,
    description text,
    facebook_link text,
    created_at timestamp default now(),
    status enum('active' ,  'inactive') default 'active'
);