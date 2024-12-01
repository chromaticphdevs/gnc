drop table if exists fn_code_purchases;

create table fn_code_purchases(

	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	codeid int(10) not null,
	branchid int(10) not null,
	reference char(20) not null,
	status enum('pending' , 'claimed')
);



SELECT u.id , username, concat(firstname , lastname) as fullname , 
u.status , max_pair , amount as purchased_level , rp.date_time as date

FROM users as u 

left join fn_product_release_payment as rp 

on rp.userid = u.id

WHERE u.status = 'gold' and username not like '%edromero%'