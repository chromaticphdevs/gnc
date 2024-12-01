create table sponsor_videos(
    id int(10) not null primary key auto_increment,
    sponsor_id int(10) not null,
    beneficiary_id int(10) not null,
    video_file text,
    approver_id int(10),
    created_at timestamp default now(),
    updated_at timestamp default now() ON UPDATE now()
);



/*
*push to prod
*/

alter table users  
    add column loan_processor_id int(10) not null;



