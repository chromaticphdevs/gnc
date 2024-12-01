UPDATE users 
    set firstname = REPLACE(firstname , '_inactive' ,'') ,
        lastname = REPLACE(lastname , '_inactive' , ''),
        mobile = LEFT(mobile , LENGTH(mobile) - 3),

        username = UPPER((CONCAT( LEFT(firstname , 1) ,
        LEFT(lastname,1) ,
        (SELECT max(id) FROM users))
        ))

        where firstname like '%_inactive%';


SELECT * from users where firstname like '%_inactive%';



CREATE TABLE `company_customer_follow_ups` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL,
 `level` tinyint(4) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 `updated_at` datetime DEFAULT current_timestamp(),
 `process_by` int(10) NOT NULL,
 `tagged_as` enum('dont-follow-up','draft','hold','active') DEFAULT 'active',
 `note` varchar(400) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1
        


CREATE TABLE `company_customer_follow_up_logs` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `remarks` varchar(100) DEFAULT NULL,
 `process_by` int(10) DEFAULT NULL,
 `note` varchar(400) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1
Query results operations