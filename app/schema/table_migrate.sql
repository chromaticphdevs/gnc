ALTER TABLE user_migrate AUTO_INCREMENT=14526;

CREATE TABLE `user_migrate` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `dbbi_id` int(10) DEFAULT NULL,
 `firstname` varchar(100) DEFAULT NULL,
 `lastname` varchar(100) DEFAULT NULL,
 `username` varchar(100) NOT NULL,
 `password` text DEFAULT NULL,
 `direct_sponsor` int(10) DEFAULT 1,
 `upline` int(10) DEFAULT 1,
 `L_R` enum('LEFT','RIGHT') DEFAULT NULL,
 `new_upline` int(10) DEFAULT NULL,
 `user_type` int(10) DEFAULT 2,
 `selfie` text DEFAULT NULL,
 `email` text DEFAULT NULL,
 `address` varchar(200) DEFAULT NULL,
 `mobile` varchar(50) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 `status` enum('pre-activated','starter','bronze','silver','gold','platinum','diamond') DEFAULT 'pre-activated',
 `max_pair` int(10) DEFAULT 0,
 `is_activated` tinyint(1) DEFAULT 0,
 `activated_by` varchar(100) DEFAULT NULL,
 `oldid`  int(10)
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14527 DEFAULT CHARSET=latin1


UPDATE users as mymg set upline = (
	SELECT id from users where oldid = mymg.upline limit 1
) where id > 21



INSERT INTO users(
	firstname , lastname , username , password , 
	direct_sponsor , upline , L_R , new_upline , branchid , user_type , 
	email , religion_id , address , mobile , status , max_pair ,
	is_activated ,oldid
)

(SELECT firstname , lastname , username , password , 
	direct_sponsor , upline , L_R , new_upline , '1' , user_type , 
	email , '1' , 'change your address' , mobile ,  status , max_pair , 
	is_activated , oldid FROM user_migrate)


21




alter table users add column oldid int(10)