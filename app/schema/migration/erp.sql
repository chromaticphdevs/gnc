CREATE TABLE `binary_points` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `userid` int(10) NOT NULL,
 `orderid` int(10) NOT NULL,
 `fromuserid` int(10) NOT NULL COMMENT 'downline that gives the point',
 `position` enum('left','right') NOT NULL,
 `points` int(10) DEFAULT NULL,
 `type` enum('flush-out','points') DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1



CREATE TABLE `binary_transactions` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `userid` int(10) NOT NULL,
 `left_vol` int(10) DEFAULT NULL,
 `right_vol` int(10) DEFAULT NULL,
 `left_carry` int(10) DEFAULT NULL,
 `right_carry` int(10) DEFAULT NULL,
 `amount` decimal(10,2) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1



CREATE TABLE `commissions` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `userid` int(10) NOT NULL,
 `fromuserid` int(10) DEFAULT '0',
 `amount` decimal(10,2) NOT NULL,
 `type` enum('binary','unilevel','drc','mentor') DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1
