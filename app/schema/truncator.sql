-- 

	-- truncate table orders;

	delete from  carts;
	alter table carts AUTO_INCREMENT = 1;

	delete from  cart_items;
	alter table cart_items AUTO_INCREMENT = 1;

	delete from  orders;
	alter table order_items AUTO_INCREMENT = 1;

	delete from  order_items;
	alter table order_items AUTO_INCREMENT = 1;

	delete from  binary_pvs;
	alter table binary_pvs AUTO_INCREMENT = 1;
	
	delete from  binary_pv_commissions;
	alter table binary_pv_commissions AUTO_INCREMENT = 1;

	delete from commissions;
	alter table commissions AUTO_INCREMENT = 1;

	delete from commission_transactions;
	alter table commissions AUTO_INCREMENT = 1;

	delete from gift_certificates;
	alter table gift_certificates AUTO_INCREMENT = 1;

	delete from binary_pv_pair_deduction;
	alter table	binary_pv_pair_deduction AUTO_INCREMENT = 1;

	delete from binary_pv_pair_counter;
	alter table binary_pv_pair_counter AUTO_INCREMENT = 1;

	delete from payouts;
	alter table payouts AUTO_INCREMENT = 1;

	delete from payout_cheque;
	alter table payout_cheque AUTO_INCREMENT = 1;

	delete from comission_deductions;
	alter table comission_deductions AUTO_INCREMENT = 1;

	delete from comission_deductions;
	alter table comission_deductions AUTO_INCREMENT = 1;
	
	delete from wallet_withdrawals;
	alter table wallet_withdrawals AUTO_INCREMENT = 1;

	truncate activated_users;
	
	-- delete from  table binary_pv_commissions;
	-- alter table binary_pv_commissions AUTO_INCREMENT = 1;

	-- delete from  table binary_pv_commissions;
	-- alter table binary_pv_commissions AUTO_INCREMENT = 1;