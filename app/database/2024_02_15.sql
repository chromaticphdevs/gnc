alter table cash_advance_payments
    add column payment_status enum('approved','for approval', 'denied') default 'approved';


alter table users 
    add video_file varchar(100);