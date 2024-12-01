create table sne_face_recognitions(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	face_image text,
	user_agent text,
	created_at timestamp default now()
);