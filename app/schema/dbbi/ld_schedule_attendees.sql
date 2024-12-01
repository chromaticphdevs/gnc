
DROP TABLE IF EXISTS ld_schedule_attendees;

create table ld_schedule_attendees(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	scheduleid int(10) not null,
	arrival_time time,
	arrival_date date,

	sched_time time ,
	sched_date date,
	remarks char(15)
);