<?php   

class CallCenterModel extends Base_model
{
public $table = "make_call";

public function call($calling, $user_mobile, $call_by)
{ 

  $get_user_device = $this->check_access($call_by);

  if(empty($get_user_device))
  {
    return "no_device";
  }

  $number = "+63".substr($user_mobile,1);

  $this->db->query(
    "INSERT INTO `{$this->table}`(`device_id`, `call_to`, `call_by`, `number`) 
      VALUES ('$get_user_device->UID', '$calling', '$call_by', '$number')"
  );

  $this->db->execute();
}

public function end_call($calling, $user_mobile)
{ 

  $number = "+63".substr($user_mobile,1);

  $this->db->query(
     "UPDATE `make_call` SET `status`='ended' 
      WHERE `call_to`='$calling' AND `number`='$number'"
  );

  return $this->db->execute();
}

public function get_number($device_id)
{

  $this->db->query(
    "SELECT id,number FROM `{$this->table}` 
     WHERE status='calling' AND device_id='$device_id' 
     ORDER BY `id` ASC"
  );

  $result = $this->db->single();

  if(!empty($result))
  {

    $data = [ 
        'id' => $result->id,
        'number' => $result->number 
        ];

    return $data;
  }
}

public function check_call_status($id)
{

  $this->db->query(
    "SELECT id FROM `{$this->table}` 
     WHERE status='ended' AND id='$id'"
  );

  $result = $this->db->single();

  if(!empty($result))
  {

    $data = [ 
        'id' => $result->id
        ];

    return $data;
  }
}

public function get_all_device()
{

  $this->db->query(
    "SELECT * FROM `gsm_device`
     WHERE status='online'"
  );

  return $this->db->resultSet();
}

public function revoke_access($userid)
{

  $this->db->query(
    "UPDATE `gsm_device` 
     SET `userid`='0', `status`='online' 
     WHERE userid='$userid'"
  );

  return $this->db->execute();
}

public function select_device($id)
{
  $call_by = whoIs()['id'];

  $this->db->query(
    "UPDATE `gsm_device` 
     SET `userid`='$call_by', status='on_use'
     WHERE id='$id'"
  );

  return $this->db->execute();
}

public function check_access($userid)
{
  $this->db->query(
    "SELECT UID FROM `gsm_device`
     WHERE status='on_use' AND userid = '$userid'"
  );

  return $this->db->single();
}

}