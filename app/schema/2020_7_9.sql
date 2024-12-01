drop table video_links_watched;
create table video_links_watched(

  id int(10) not null primary key auto_increment,
  user_id int(10) not null,
  link_id int(10) comment 'video link id',
  watch_date timestamp default now()
);


alter table video_links
    add column position int(10)
    after id;


update table video_links as vl
  set position = 1;

update video_links as vl set position = (SELECT id from video_links where vl.id = video_links.id);

  (SELECT id from video_links where vl.id = video_links.id);
