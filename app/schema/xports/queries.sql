insert into users(id , username , upline , L_R , direct_sponsor , user_type , firstname , lastname , password , 
wallet_balance , left_volume ,right_volume , pair_counter , maximum_pair , total_pair , selfie , 
email , created_at)

SELECT u.id , u.username , u.upline , 'left' ,

	if(u.sponsor > 0  , u.sponsor , 0) , '2' , if(ui.firstname < 0 , 'no name' , ui.firstname)  , 
	if(ui.lastname < 0 , 'no lastname' , ui.lastname) , 

	if(u.password < 0 , 'nopassword' , u.password ), '0' , '0' , '0' ,'0' ,'0 ','0' , 'default.png' , 
	if(ui.email < 0 , 'noemail' , ui.email) , u.date

from users_xported as u left join 
user_informations_xported as ui 

on u.id = ui.userid




