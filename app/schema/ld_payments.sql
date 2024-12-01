alter table ld_cash_payments add column loan_id int(10) not null;

alter table ld_cash_payments add column branch_id int(10);

alter table ld_cash_payments add column principal_amount decimal(10 ,2);

alter table ld_cash_payments add column interest_amount decimal(10 ,2);



alter table ld_cash_payments drop column loan_id;
alter table ld_cash_payments drop column branch_id;
alter table ld_cash_payments drop column principal_amount;
alter table ld_cash_payments drop column interest_amount;


alter table ld_product_payments drop column loan_id;
alter table ld_product_payments add column loan_id int(10) not null;
