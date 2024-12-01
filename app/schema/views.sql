
-- users information

SELECT id , username , upline , L_R , direct_sponsor , user_type , 
firstname , lastname , password , left.points as left_volume , right.right_volume as right_volume 

from users as u 

left join bpv_commission_left as left on left.c_id = u.id 

left join bpv_commission_right as right on right.c_id = u.id


left join commissions as c on c.c_id = u.id 
-- users binary

CREATE VIEW bpv_commission_left as SELECT sum(points)  as points, c_id  from binary_pv_commission where pos_lr = 'left' group by c_id;

CREATE VIEW bpv_commission_right as SELECT sum(points)  as points, c_id  from binary_pv_commission where pos_lr = 'right' group by c_id;

CREATE VIEW drc_commissions as SELECT sum(amount) as amount , c_id from commissions where type = 'DRC' group by c_id
---

SELECT u.id as u_id , username , upline , L_R , direct_sponsor , user_type , 
firstname , lastname , password , c.amount as drc_amount , ifnull(bpv_left.points , 0) as 

left_volume , ifnull(bpv_right.points  ,0 ) as right_volume ,

CASE WHEN 
	 ifnull(bpv_right.points  ,0 ) > ifnull(bpv_left.points , 0)
	 THEN 
	ceil(ifnull(bpv_right.points  ,0 )  / 100) * 100 end as binary_commission

from users as u 

left join bpv_commission_left as bpv_left on bpv_left.c_id = u.id 

left join bpv_commission_right as bpv_right on bpv_right.c_id = u.id

left join drc_commissions as c on c.c_id  = u.id

group by u.id



--drc views

create view drc_commission as SELECT * FROM commissions where type = 'DRC';
create view unilvl_commission as SELECT * FROM commissions where type = 'UNILVL';

--users view


create view users_view as SELECT u.username username ,u.upline as upline , u.L_R as L_R , u.direct_sponsor as direct_sponsor ,
u.user_type as user_type ,u.firstname as firstname , u.lastname as lastname ,
bpvc.left_volume as left_volume , bpvc.right_volume as right_volume , bpvc.left_carry as left_carry,
bpvc.right_carry as right_carry , mp.max_pair as max_pair , bpvc.pair as pair_counter ,  bpvc.amount as amount


from users as u 

left join binary_pv_commissions as bpvc

on u.id = bpvc.user_id

left join max_pair as mp 

on u.id = mp.user_id 


drop view binary_lvol_total;
drop view binary_rvol_total;


create view binary_lvol_total as SELECT c_id as user_id , sum(points) as total_volume from binary_pvs 
	where pos_lr = 'left' group by c_id;

create view binary_rvol_total as SELECT c_id as user_id ,  sum(points) as total_volume from binary_pvs 
	where pos_lr = 'right' group by c_id;