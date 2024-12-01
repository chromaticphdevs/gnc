

alter table ld_users add column id_image_back text after id_image;


alter table users add column dbbi_id int(10) after id;


alter table users add column from_application char(30);
/*transfer previous accounts*/



INSERT INTO users (dbbi_id , firstname , lastname , username , password , 
direct_sponsor , upline , L_R , new_upline , user_type , selfie , email , 
address , mobile , created_at , status , max_pair)



SELECT id , firstname , lastname , email , '1111',
'7' , '7' , 'LEFT' , '7' , '2' , '' , email , '' , phone , created_on  , '1' , 'pre-activated','0' 
FROM ld_users 


WHERE email not in (SELECT email FROM users)


SELECT * FROM ld_users where email not in (SELECT email from users where id > 10000);




INSERT INTO users (dbbi_id , firstname , lastname , username , password , 
direct_sponsor , upline , L_R , new_upline , user_type , selfie , email , 
address , mobile , created_at , status , max_pair)

SELECT id , firstname , lastname , email , '1111',

'7' , '7' , 'LEFT' , '7' , '2' , '' , email,
'address',phone , created_on  , 'pre-activated' ,'0'  
FROM ld_users where email not in(SELECT email FROM users where email not in 
	(SELECT email from ld_users) group by email
) 

-- SELECT email
-- FROM ld_users where email not in(SELECT email FROM users where email not in 
-- 	(SELECT email from ld_users) group by email
-- )