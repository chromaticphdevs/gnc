<?php

    /**
     * GET users link whether the positio is left or right
     * this function accepts directsponsorId , uplineId and position
     * paremeters are optional
     * 
     * if directsponsor or uplineId is null
     * the currently loggedin user will be set to both
     */
    function getUserLink($uplineId = null , $directSponsorId = null , $position = null)
    {
        $userId = whoIs()['id'];

         $endpoint = 'https://signup-e.com/RegistrationSignup';

        if(is_null($uplineId))
            $uplineId = $userId;

        if(is_null($directSponsorId))
            $directSponsorId = $userId;

        /**
         * identify users highest binary
         * set the position to the lowest binary if position 
         * null
         */

        $userBinaryModel = new UserBinaryModel($userId);

        $binaryModel = model('Binary_model');

        $dbInstance = Database::getInstance();

        $binary = $userBinaryModel->get_recent_transaction();

         //set position
        if(is_null($position))
        {
            $position = 'LEFT';
            if( intval($binary->left ?? 0) > intval($binary->right ?? 0))
                $position = 'RIGHT';
        }

        //check if binary position is already taken
        $dbInstance->query(
            "SELECT username FROM `users` 
                WHERE upline = '$uplineId' and L_R = '$position'"
        );
        $check_upline = $dbInstance->resultSet();

        //if taken then change the upline to 
        //available user without downline on position given
        if(!empty($check_upline)) {
            $uplineId = $binaryModel->outDownline($uplineId, $position);
        }

        return $endpoint.'?q='.seal("position={$position}&direct={$directSponsorId}&uplineid={$uplineId}");
    }