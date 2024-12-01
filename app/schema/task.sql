
drop table if exists tasks;
create table tasks(
	id int(10) not null primary key auto_increment,
	link text,
	category enum('like' , 'share' , 'subs' , 'click' , 'watch'),
	points decimal(10 , 2) ,
	dailytaskid int(10) not null comment 'daily daskid'
);

drop table if exists daily_tasks;
create table daily_tasks(
	id int(10) not null primary key auto_increment,
	startdate date ,
	totalpoints decimal(10 , 2) , 
	created_at timestamp default now()
);



drop table if exists tasks_finished;


create table tasks_finished(
	id int(10) not null primary key auto_increment ,
	userid int(10) not null,
	taskid int(10) not null,
	link text,
	category enum('like' , 'share' , 'subs' , 'click' , 'watch'),
	points decimal(10 ,2),
	proof_link text,
	proof_ss text,
	created_at timestamp default now()
);

drop table if exists users_daily_task_finished;
create table users_daily_task_finished(
	id int(10) not null primary key auto_increment ,
	userid int(10) not null,
	dailytaskid int(10) not null,
	date timestamp default now(),
	finished_on timestamp default now()
)

alter table task_watch_answers add column correct_answer text;
alter table task_watch_answers add column question text after questionid;