delete from comission_deductions 
where date(dt) = date(now());



delete from payouts
where date(date_to) = date(now());


delete from payout_cheque
	where payout_id = 3;


	delete from comission_deductions;


	delete from payouts;

	delete from payout_cheque;