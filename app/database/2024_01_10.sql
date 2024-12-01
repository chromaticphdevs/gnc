alter table  fn_cash_advances 
        add column interest_rate varchar(50),
        add column payment_method varchar(100);


drop table if exists fn_cash_advances_attributes;
create table fn_cash_advances_attributes(
    id int(10) not null primary key auto_increment,
    fn_ca_id int(10) not null,
    parent_id int(10),
    attribute_key varchar(50),
    attribute_value text,
    attribute_label varchar(100),
    create_at timestamp default now()
);