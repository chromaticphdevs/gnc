alter table fn_cash_advances
    add column attornees_fee decimal(10,2);


create table x_chat_sessions(
    id int(10) not null primary key auto_increment,
    title varchar(100),
    admin_id int(10) not null,
    date date,
    color char(17),
    is_gc boolean default false,
    created_at timestamp default now()
);

create table x_chat_members(
    id int(10) not null primary key auto_increment,
    gc_id int(10) not null,
    mem_id int(10),
    added_by int(10),
    created_at timestamp default now()
);

drop table if exists x_chats;
create table x_chat_one_to_one(
    id int(10) not null primary key auto_increment,
    sender_id int(10) not null,
    recipient_id int(10) not null,
    chat text,
    created_at timestamp default now()
);

create table x_chat_connection(
	id int(10) not null primary key auto_increment,
    connection_key varchar(26),
    parent_id int(10),
    child_id int(10),
    updated_at datetime
);

drop table if exists x_chat_group_messages;
create table x_chat_group_messages(
    id int(10) not null primary key auto_increment,
    gc_id int(10) not null,
    sender_id int(10) not null,
    chat text,
    link text,
    is_attachment  boolean default false,
    reply_to int(10),
    created_at datetime
);