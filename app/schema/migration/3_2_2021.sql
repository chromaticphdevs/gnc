alter table 
	fn_product_release add 
	column shipment_status enum('pending' , 'delivered') default 'pending';


	update fn_product_release set shipment_status = 'delivered';