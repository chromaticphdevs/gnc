


create table gift_certificates
(
  id int(10) not null primary key auto_increment,
  userid int(10) not null,
  amount decimal(10 ,2),
  is_consumed boolean default false,
  created_at timestamp default now()
);


alter table gift_certificates add column next_gc int(10);
