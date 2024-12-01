alter table users 
	add column updated_on timestamp default now()
	ON UPDATE CURRENT_TIMESTAMP;