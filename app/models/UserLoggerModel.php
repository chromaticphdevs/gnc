<?php 	

	class UserLoggerModel extends Base_model
	{	

		public $table = 'user_login_logger';

		public function addQRLogin($userId, $groupId) {
			return $this->add($userId, 'QR_CODE', $groupId);
		}
		public function add($userId, $type, $groupId = null) {
			$today = today();
			if($type == 'QR_CODE') {
				//check first if already logged 
				$loggedToday = parent::dbget_single(
					"userid = '{$userId}' and type = '{$type}'
					and date(date_time) = date('{$today}')"
				);

				if($loggedToday) {
					$this->addError("You are already logged in today, please login tommorow");
					return false;
				}
			}

			return parent::store([
				'userid' => $userId,
				'date_time' => $today,
				'type' => $type,
				'group_id' => $groupId
			]);
		}

		public function getLogs($params = []) {
			$where = null;

			if(isset($params['where'])) {
				$where = " WHERE ". parent::convertWhere($params['where']);
			}

			$this->db->query(
				"SELECT user.*, mlog.date_time as date_time,
					mlog.group_id
					FROM {$this->table} as mlog
					LEFT JOIN users as user 
					ON user.id = mlog.userid
					{$where}"
			);	

			return $this->db->resultSet();
		}

		public function getLogsToday($type = '') {
			$today = today();

			if(empty($type)) {
				$this->db->query(
					"SELECT user.*, mlog.date_time as date_time,
						mlog.group_id
						FROM {$this->table} as mlog
						LEFT JOIN users as user 
						ON user.id = mlog.userid
						WHERE mlog.type = 'QR_CODE'"
				);
			} else {
				$this->db->query(
					"SELECT user.*, mlog.date_time as date_time,
						mlog.group_id
						FROM {$this->table} as mlog
						LEFT JOIN users as user 
						ON user.id = mlog.userid
					WHERE date(mlog.date_time) = date('{$today}')
					
					and mlog.type = '{$type}'"
				);	 
			}
			return $this->db->resultSet();
		}

		/** FETCH LOGGED IN 1 HOUR BEFORE*/
		public function get_user_login()
		{
			$this->db->query(
				"SELECT * FROM `user_login_logger` as user_logger INNER JOIN users as users 
				 WHERE users.id = user_logger.userid

				 AND user_logger.date_time > DATE_SUB(NOW(), INTERVAL 1 HOUR)

				 ORDER BY user_logger.date_time DESC"
			);

			return $this->db->resultSet();
		}

		public function get_user_logout()
		{
			$this->db->query(
				"SELECT * FROM `user_logout_logger` as user_logger INNER JOIN users as users 
				 WHERE users.id = user_logger.userid

				 AND user_logger.date_time > DATE_SUB(NOW(), INTERVAL 1 HOUR)
				 ORDER BY user_logger.date_time DESC"
			);

			return $this->db->resultSet();
		}

	}