

/*4/20/2020*/
create table governmentids(
    id int(10) not null primary key auto_increment,
    name text,
    type enum('primary' , 'secondary')
);


