create table legalities(
  id int(10) not null primary key auto_increment,
  name varchar(100),
  path text,
  filename text,
  created_at timestamp default now()
);
