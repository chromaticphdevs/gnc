create table user_credit_line(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    current_credit_line decimal(10,2),
    previous_credit_line decimal(10,2),
    last_update_previous_credit_line datetime,
    last_update_current_credit_line datetime,
    updated_by int(10)
);

/*
*sql add credit line default 1,000.00
*
**/


truncate current_credit_line;

INSERT INTO user_credit_line (user_id, current_credit_line, last_update_current_credit_line)
    (SELECT id, 1000, NOW() FROM users)


truncate user_credit_line;