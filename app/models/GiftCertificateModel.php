<?php

  class GiftCertificateModel extends Base_model
  {

    private $table_name = 'gift_certificates';

    public function divisibleByFive($pair)
    {
      if(($pair % 5) == 0)
        return true;
      return false;
    }

    public function make_giftcert($userid , $quantity , $amount)
    {

      $sql = "INSERT INTO $this->table_name(userid , amount , next_gc)
      VALUES";

      $counter = 0;
      for ($i = 0 ; $i < $quantity ; $i++)
      {
        if($counter < $i) {
          $sql .= ",";
          $counter ++;
        }
        $sql .= "('$userid' , '$amount' , '$i')";
      }
      try{
        $this->db->query($sql);
        
        $this->db->execute();
        return true;
      }catch(Exception $e) {
        die($e->getMessage());
        return false;
      }
    }


    private function compute_nextgc($currentPair)
    {
      for($i = 3 ; $i < 100000 ; $i += 3)
      {
        if($currentPair < $i)
        {
          return $i;
          break;
        }
      }
      return 0;
    }

    
    public function get_recent_gc($userid)
    {
      $this->db->query(
        "SELECT * FROM $this->table_name
          WHERE userid = '$userid' and date(created_at) = date(now())
          ORDER by id desc limit 1"
      );

      return $this->db->single();
    }

    public function get_total_amount($userid)
    {
      $this->db->query(
        "SELECT sum(amount) as total
          FROM $this->table_name where userid = '$userid'"
      );

      $result = $this->db->single();

      if($result)
        return $result->total;
      return 0;
    }

    public function get_total($userid)
    {
      $this->db->query(
        "SELECT count(amount) as total
          FROM $this->table_name where userid = '$userid'"
      );

      $result = $this->db->single();

      if($result)
        return $result->total;
      return 0;
    }
  }
