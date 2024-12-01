alter table 
    cash_advance_co_borrowers add column benefactor_id int(10) comment 'loan borrower';


/*
*migrate loans
*/
UPDATE cash_advance_co_borrowers
    INNER JOIN fn_cash_advances as loan
        ON loan.id = cash_advance_co_borrowers.fn_ca_id
    SET cash_advance_co_borrowers.benefactor_id = loan.userid



SELECT userid, fn_cash_advances.id, cdcb.fn_ca_id
    FROM fn_cash_advances
        INNER JOIN cash_advance_co_borrowers as cdcb
            ON  cdcb.fn_ca_id = fn_cash_advances.id



/*testl oan query*/
UPDATE users_uploaded_id set status = 'unverified' where date(date_time) = '2024-02-08';