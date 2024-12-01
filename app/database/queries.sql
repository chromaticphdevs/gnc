SELECT * FROM users 
    where id in (
        SELECT user_id from ca_qualified_users
            where user_id not in (
                SELECT * FROM fn_cash_advances
            )
    );


/**
*UPDATE LOAN AMOUNT*/

UPDATE fn_cash_advances
    set balance = 1000,
    net = 1000,
    amount = 1000;




SELECT concat(user.firstname, '',user.lastname) as fullname,
    fca.code as loan_reference,
    cdr.amount as release_amount,
    fca.net as initial_balance,
    fca.balance as remaining_balance,
    fca.status as loan_status
    
    FROM cash_advance_releases as cdr
	LEFT JOIN fn_cash_advances as fca
        ON fca.id = cdr.ca_id
    LEFT JOIN users as user
        ON user.id = fca.userid 

    WHERE fca.status in ('paid','released')


    update fn_cash_advances
        set balance = 0,
        attornees_fee = (attornees_fee - 100)

        WHERE is_released = true
        and status = 'paid'
        and balance != 0;



    SELECT * FROM  fn_cash_advances
    WHERE is_released = true
        and status = 'paid'
        and balance != 0;


    DELETE FROM loan_logs
        where loan_id in (
             SELECT id FROM  fn_cash_advances
            WHERE is_released = true
                and status = 'paid'
                and balance != 0

        );



UPDATE users 
    set page_auto_focus = 'REFERRAL_PAGE'
    WHERE is_user_verified = true
    AND user_type = 2;

UPDATE users 
    set page_auto_focus = 'CASH_ADVANCE_PAGE'
    WHERE is_user_verified = true
        AND id in (
            SELECT userid from fn_cash_advances
        )
    AND user_type = 2;


UPDATE users 
    set page_auto_focus = 'UPLOAD_ID_PAGE'
    WHERE is_user_verified = false
    AND user_type = 2;


UPDATE users 
    SET page_auto_focus = 'CASH_ADVANCE_PAGE'
        WHERE id in(
            SELECT userid from  fn_cash_advances
                where status = 'released'
        );
SELECT * FROM users
    W