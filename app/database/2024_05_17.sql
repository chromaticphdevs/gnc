alter table cash_advance_releases
    add column due_date_no_of_days tinyint;

alter table cash_advance_releases
    add column due_date date;

/*
*run queries
*/

update cash_advance_releases
    SET due_date_no_of_days = 60,
    due_date = DATE_FORMAT('%Y-%m-%d', DATE_ADD(entry_date, INTERVAL 60 DAY));
 