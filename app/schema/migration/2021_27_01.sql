drop table bk_app_versioning;
create table bk_app_versioning(
	id int(10) not null primary key auto_increment,
	version_key varchar(100) not null,
	version_number varchar(15) not null,
	status enum('latest' , 'stable' , 'deprecated') default 'latest',
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
);

/*insert query*/

insert into bk_app_versioning(
	version_key , version_number , status 
) VALUES('GvmSyPv4KarRor8DHBtNL1BTBRn2ZzVF','v2.05'  , 'latest');