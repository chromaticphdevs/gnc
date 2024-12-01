alter table fn_cash_advances
  add column is_shown boolean default true
  comment 'for re-loaning same amount purpose'
  after notes
