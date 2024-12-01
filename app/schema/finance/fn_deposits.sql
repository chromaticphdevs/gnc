drop table if exists fn_deposits;

CREATE TABLE `fn_deposits` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `branchid` int(10) NOT NULL,
 `branch_origin` int(10) NOT NULL,
 `amount` decimal(10,4) DEFAULT NULL,
 `description` text DEFAULT NULL,
 `status` enum('on-queue','confirmed','declined') DEFAULT 'on-queue',
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
);