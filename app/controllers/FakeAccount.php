<?php

  class FakeAccount extends Controller
  {
    public function index()
    {
      /**
      *FAKE ACCOUNTS
      **/

      for($i = 0 ; $i < 5 ; $i++)
      {
        $firstname = get_token_random_char(12);
        $lastname = get_token_random_char(3);
        $direct_sponsor = 1;
        $upline = 1;

        $db->query("INSERT INTO users(
          firstname , lastname , direct_sponsor,
          upline , L_R , branchId, username ,
          password , max_pair
        )VALUES(
          '$firstname' , '$lastname' , '$direct_sponsor',
          '$upline' , '$position' , '$branchid' , '$username',
          '$password' , '$max_pair'
        )");
      }
    }
  }
