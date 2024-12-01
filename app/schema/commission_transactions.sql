--track purchaser
/*FEB 6*/
alter table commission_transactions add column purchaserid int(10) not null after userid;