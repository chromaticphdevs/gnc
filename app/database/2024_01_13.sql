drop table if exists cash_advance_co_borrowers;
create table cash_advance_co_borrowers(
    id int(10) not null primary key auto_increment,
    fn_ca_id int(10),
    co_borrower_id int(10),
    co_borrower_approval char(10) default 'pending',
    staff_approval char(10) default 'pending',

    co_borrower_remarks text,
    staff_remarks text,

    staff_approval_by int(10),
    created_at timestamp default now(),
    last_update datetime
);


create table user_notifications(
    id int(10) not null primary key auto_increment,
    message text,
    link text,
    user_id int(10) not null,
    is_read boolean default false,
    created_at timestamp default now()
);