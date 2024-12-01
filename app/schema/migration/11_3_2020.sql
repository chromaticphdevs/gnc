create table follow_ups(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    level tinyint,
    created_at timestamp default now(),
    updated_at datetime default CURRENT_TIMESTAMP default CURRENT_TIMESTAMP
);


alter table follow_ups 
    add column approved_by int(10) not null,
    add column tagged_as enum('dont-follow-up' , 'draft' , 'hold' , 'active') default 'active';




create table follow_up_logs(
	id int(10) not null primary key auto_increment,
    remarks varchar(100),
    approved_by int(10),
    created_at timestamp default now()
);