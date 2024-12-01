<?php

    class UserGeneologyModel extends Base_model
    {
      /*
      *Used by BinaryGeneology
      *DO NOT DELETE
      */
        public function get_user($userid)
        {
            return
                $this->userFormat($this->getUserInfo($userid) , $this->getDownlines($userid));
        }

        private function userFormat($userInfo , $downlines) {

            return[
                'id'        => $userInfo->id ?? null,
                'username'  => $userInfo->username ?? null ,
                'status'    => $userInfo->status ?? null ,
                'left'      => $userInfo->left_carry ?? null,
                'right'     => $userInfo->right_carry ?? null,
                'uplineid'  => $userInfo->uplineid ?? null,
                'downlines' => $downlines
            ];
        }

        public function getDownlines($userid)
        {
            $this->db->query(
                "SELECT id FROM users where upline = '$userid' and L_R = 'left' order by id desc limit 1"
            );

            $left = $this->db->single()->id ?? null;

            $this->db->query(
                "SELECT id FROM users where upline = '$userid' and L_R = 'right' order by id desc limit 1"
            );

            $right = $this->db->single()->id ?? null;

            return [
                $left , $right
            ];
        }

        public function getUserInfo($userid) {
            $this->db->query(
                "SELECT id , username , status, upline,
                    (SELECT ifnull(left_carry , 0)  from binary_transactions  where userid = '$userid' order by id desc limit 1) as left_carry ,
                    (SELECT ifnull(right_carry , 0) from binary_transactions  where userid = '$userid' order by id desc limit 1) as right_carry
                FROM users where id = '$userid'"
            );

            return $this->db->single();
        }

        /*
        *Parameters can be an array of userids
        *or id only
        */
        public function getBranch($params)
        {
          $userModel = new LDUserModel();
          // $binary = new UserBinaryPv();

          if(is_array($params))
          {
            $user_ids = implode(',' , $params);

            $WHERE = "upline in({$user_ids})";
            /*
            *this is a very important sorting
            *for our binary branch formatter to work
            */
            $ORDERBY = " L_R asc ";

            $results = $userModel->getRawMultiple([
              'username',
              'id',
              'upline',
              'L_R',
              'status'
            ] , $WHERE , $ORDERBY);

            //get users binaryPV
            foreach($results as $key => $row)
            {
              $binary = new UserBinaryModel($row->id);
              $binaryRecent = $binary->get_recent_transaction();

              if($binaryRecent) {
                $row->binary = [
                  'left' => $binaryRecent->left_vol,
                  'right' => $binaryRecent->right_vol
                ];
              }else{
                $row->binary = [
                  'left' => 0,
                  'right' => 0
                ];
              }

            }

            return $this->reArrange($params , $results);
          }
        }
        /*
        *Arrange results relelative to
        *passed user-ids
        */
        public function reArrange($passedParams , $results)
        {
          $returnData = [];

          $pairs = [];

          while(!empty($results))
          {
            foreach($passedParams as $index => $uplineid)
            {
              foreach($results as $key => $user)
              {
                if($uplineid == $user->upline)
                {
                  $pairs[] = $user;
                  unset($results[$key]);
                }
              }

              //if upline does not have bothleg
              if(count($pairs) < 2) {
                $pairs[1] = '';
              }
              $returnData[] = $pairs;

              /*RESET PAIR*/
              $pairs = [];
            }
          }

          /*Arrange pairs from left to right*/
          $newArrangement = [];
          foreach($returnData as $key => $pair)
          {
            foreach($pair as $parirKey => $leaf)
            {
              if($parirKey == 0 && strtolower($leaf->L_R) == 'right') {
                $switch = [
                  $pair[1],
                  $pair[0]
                ];
                $pair = $switch;
              }
            }
            $newArrangement[] = $pair;
          }
          return $newArrangement;
        }

        /*
        *get downline with levels
        *return userid only
        */

        public function getDownlinesWithLevel($base , $level)
        {
          $userModel = new LDUserModel();
          //result storage
          $returnData = [];

          $bases = [];
          $bases[] = $base; // initially set bases to base

          $inc = 0;
          while($inc != $level)
          {
            $WHERE = " upline in (".implode(',' , $bases).")";
            $downlines = $userModel->getRawMultiple(['id'] , $WHERE ,  " L_R ASC");

            //ressetting bases
            $bases = $this->extractDownlines($downlines);

            $returnData = array_merge($returnData , $bases);
            // $returnData[] = $bases;
            $inc++;
          }

          return $returnData;
        }

        public function userInfo($id)
        {
          $userModel = new LDUserModel();

          return $userModel->getRawSingle([
            'username',
            'id',
            'upline',
            'L_R',
            'status'
          ] , " id = '$id'");
        }

        public function extractDownlines($downlines)
        {
          $returnData = [];
          foreach($downlines as $key => $row)
          {
            if(is_array($row)){
              foreach($row as $i) {
                if(is_object($i))
                $returnData[] = $i->id;
              }
            }else{
              $returnData[] = $row->id;
            }
          }

          return $returnData;
        }


        /*
        *TEMPORARY QUERY
        *NOT OPTIMIZED
        */
        public function getWithMultipleDownlines()
        {

          $this->db->query(
            "SELECT * , upline_data.id as upline_id , 
            upline_data.username as upline_username,
            count(u.id) as uplines 

            FROM users as u

            LEFT JOIN users as upline_data
            on u.upline = upline_data.id
            
            WHERE u.upline != ''
            GROUP BY u.upline order by uplines desc limit 100"
          );

          $users = $this->db->resultSet();

          foreach($users as $key => $row) 
          {

            if($row->uplines <= 2) break;

            $this->db->query(
              "SELECT count(id) as total FROM users
                where upline = '$row->upline_id'
                AND L_R = 'left'"
            );

            $row->uplineLeft = $this->db->single();

            $this->db->query(
              "SELECT count(id) as total FROM users
                where upline = '$row->upline_id'
                AND L_R = 'right'"
            );

            $row->uplineRight = $this->db->single();
          }

          return $users;
        }

        /*
        *TEMPORARY QUERY
        *NOT OPTIMIZED
        */

        public function getDownlinesMultipleAllowed($userid)
        {
            $this->db->query(
              "SELECT * FROM users 
                WHERE upline = '{$userid}' order by created_at asc "
            );

            return $this->db->resultSet();
        }
    }
