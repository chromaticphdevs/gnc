<?php 	

	function get_user_uplines($userId) 
	{
		$user_model = model('User_model');
		$uplineArray = [];
		$uplineQueue = $user_model->user_get_upline($userId);

		while ($uplineQueue) {
			$uplineArray[] = $uplineQueue; 
			$userId = $uplineQueue->id;  
			$uplineQueue = $user_model->user_get_upline($userId);
		}

		return $uplineArray;
	}