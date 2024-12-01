update fn_cash_advances
    set balance = net;


ALTER TABLE fn_cash_advances
    add column is_released boolean default false,
    add column release_date datetime default null;
