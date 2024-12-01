SELECT sum(price) FROM `ld_activation_code` where created_on > '2020-02-01 03:44:02' and status = 'Used';


SELECT * FROM order_items where dt > '2020-02-01 03:44:02';


--transfer ld_payin 
INSERT INTO ld_payin_transactions(purchaser , amount , dateandtime , type , origin)

SELECT user_id , price , created_on , 'code' , company
	FROM ld_activation_code where status = 'Used';


--transfer ld_payin orders
INSERT INTO ld_payin_transactions(purchaser, amount , dateandtime , type , origin)

SELECT user_id , price , dt , 'order' , 'sne'
	FROM orders 
		LEFT JOIN order_items 
		ON orders.id = order_items.order_id 
		WHERE dt > '2020-02-01 03:44:02';