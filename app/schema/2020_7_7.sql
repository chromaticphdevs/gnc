

drop table in_code_libraries;
create table in_code_libraries(
  id int(10) not null primary key auto_increment,
  product_id int(10) comment 'Inventory product id',
  name varchar(100),
  box_eq int(10),
  drc_amount decimal(10 , 2),
  unilevel_amount decimal(10 , 2),
  binary_point int(10),
  distribution int(10),
  level char(50),
  max_pair smallint(6),
  status 	enum('available', 'released', 'used', 'expired'),

  amount_discounted decimal(10 , 2),
  amount_original decimal(10 , 2),
  category enum('activation' , 'non-activation'),

  created_at timestamp default now()
);
