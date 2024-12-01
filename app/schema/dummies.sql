--users

insert into users(user_type , firstname , lastname , username , password , direct_sponsor ,
upline , L_R , email)


VALUES('2' , 'dummy1' , 'i am a dummy' , 'dummy1' ,'1111' ,'1','1','LEFT','dummy1@email.com'),
('2' , 'dummy2' , 'i am a dummy' , 'dummy2' ,'1111' ,'2','2','LEFT','dummy2@email.com'),
('2' , 'dummy3' , 'i am a dummy' , 'dummy3' ,'1111' ,'3','3','LEFT','dummy3@email.com'),
('2' , 'dummy4' , 'i am a dummy' , 'dummy4' ,'1111' ,'4','4','LEFT','dummy1@email.com'),
('2' , 'dummy5' , 'i am a dummy' , 'dummy5' ,'1111' ,'4','4','LEFT','dummy1@email.com'),
('2' , 'dummy6' , 'i am a dummy' , 'dummy6' ,'1111' ,'4','4','RIGHT','dummy1@email.com')
;

--update all password

update users set password = '$2y$10$biYEqkGVQF0StXKVds1tfOrnPiPCaOe1.YhyuO4r3BoTR8PHIJisy';




LAST USER

9651


YouVhergeen04