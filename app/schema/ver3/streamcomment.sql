/*4/5/2020*/

create table stream_comments(

    id int(10) not null primary key auto_increment,
    streamid int(10) not null,
    userid int(10) not null,
    comment varchar(191),
    created_at timestamp default now(),
    is_removed boolean default false
);