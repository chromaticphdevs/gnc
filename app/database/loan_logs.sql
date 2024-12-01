
drop table if exists loan_logs;
create table loan_logs(
    id int(10) not null primary key auto_increment,
    loan_id int(10) not null comment 'fk from fn_cash_advances',
    user_id int(10) not null,
    entry_type varchar(50),
    amount decimal(10,2),
    loan_attribute varchar(50),
    penalty_date datetime,
    remarks text,
    created_at datetime
);

drop table if exists loan_jobs;
create table loan_jobs(
    id int(10) not null primary key auto_increment,
    job_name varchar(50),
    job_key varchar(50),
    description text,
    created_at timestamp default now(),
    last_run datetime
);

insert into loan_jobs
    (job_name, job_key, description, last_run)
        VALUES ('DAILY PENALTY', 'DAILY_CUTOFF_PENALTY', 'penalizes users with no payment daily', '2024-03-01');