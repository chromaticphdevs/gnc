
create table face_recognitions(
	id int(10) not null primary key auto_increment
	fullname varchar(100) not null,
	age int(10) ,
	gender char(15) ,
	registration_face text,
	created_at timestamp default now()
);