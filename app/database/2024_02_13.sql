alter table user_notifications
    add column parent_key char(50),
    add column parent_id int(10)