add category field on fn_cash_advance_payment

alter table fn_cash_advance_payment
  add column branch_id int(10) after userid,
  add column path text after image


alter table fn_cash_advance_payment
  add column category enum('Regular Payment' , 'Available Earnings');
