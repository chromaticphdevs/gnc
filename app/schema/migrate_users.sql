
drop table if exists users;
CREATE TABLE `users` (
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
 `branchId` int(11) NOT NULL,
 `user_type` int(10) DEFAULT 2,
 `selfie` text DEFAULT NULL,
 `email` text DEFAULT NULL,
 `religion_id` int(11) DEFAULT NULL,
 `address` varchar(200) DEFAULT NULL,
 `mobile` varchar(50) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 `status` enum('pre-activated','starter','bronze','silver','gold','platinum','diamond') DEFAULT 'pre-activated',
 `max_pair` int(10) DEFAULT 0,
 `is_activated` tinyint(1) DEFAULT 0,
 `activated_by` varchar(100) DEFAULT NULL,
 `old_id` int (10),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1