drop table if exists accounts_ledger;
create table accounts_ledger(
    id int(10) not null primary key auto_increment,
    ledger_reference varchar(50) not null,
    ledger_source varchar(100) not null,
    ledger_source_id int(10) not null,
    ledger_user_id int(10) not null,

    ledger_entry_amount decimal(10,2),
    ledger_entry_type enum('addition','deduction'),
    previous_balance decimal(10,2),
    ending_balance decimal(10,2),
    description text,
    entry_dt datetime,
    status enum('approved', 'cancelled') default 'approved',
    admin_remarks text,
    created_at datetime default now(),
    updated_at datetime,
    updated_by int(10),
    created_by int(10)
);


alter table accounts_ledger add column
    category varchar(100);


/*
*deduct applied attornees fees today
*add re-imburse penalty
*/

/*
*select items from penalties 
*/

SELECT FROM accounts_ledger
    WHERE category = 'PENALTY_ATTORNEES_FEE'
    AND date('entry_dt') = '2024-08-15';



