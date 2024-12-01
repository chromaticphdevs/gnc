drop table if exists loan_processor_videos;
create table loan_processor_videos(
    id int(10) not null primary key auto_increment,
    loan_processor_id int(10) not null,
    beneficiary_id int(10) not null,
    video_file text,
    approver_id int(10),
    created_at timestamp default now(),
    updated_at timestamp default now() ON UPDATE now()
);


