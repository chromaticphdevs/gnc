drop table if exists activated_users;

ALTER TABLE `binary_pvs` ADD PRIMARY KEY(`id`);
ALTER TABLE `binary_pvs` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `binary_pv_commissions` ADD PRIMARY KEY(`id`);
ALTER TABLE `binary_pv_commissions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `binary_pv_pair_counter` ADD PRIMARY KEY(`id`);
ALTER TABLE `binary_pv_pair_counter` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `binary_pv_pair_deduction` ADD PRIMARY KEY(`id`);
ALTER TABLE `binary_pv_pair_deduction` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `binary_transactions` ADD PRIMARY KEY(`id`);
ALTER TABLE `binary_transactions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `change_pwd_sessions` ADD PRIMARY KEY(`id`);
ALTER TABLE `change_pwd_sessions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comission_deductions` ADD PRIMARY KEY(`id`);
ALTER TABLE `comission_deductions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `commissions` ADD PRIMARY KEY(`id`);
ALTER TABLE `commissions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `commission_transactions` ADD PRIMARY KEY(`id`);
ALTER TABLE `commission_transactions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fn_accounts` ADD PRIMARY KEY(`id`);
ALTER TABLE `fn_accounts` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fn_cash_advances` ADD PRIMARY KEY(`id`);
ALTER TABLE `fn_cash_advances` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fn_cash_advance_code_payment` ADD PRIMARY KEY(`id`);
ALTER TABLE `fn_cash_advance_code_payment` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fn_cash_advance_request` ADD PRIMARY KEY(`id`);
ALTER TABLE `fn_cash_advance_request` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

drop table carts;

drop table cart_items;


binary_pvs