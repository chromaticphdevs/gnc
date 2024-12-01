<?php 	

	class UsertaskModel extends Base_model
	{

		private $table_name = 'tasks_finished';

		public function get_list()
		{
			$userid = Session::get('USERSESSION')['id'];

			$this->db->query(
				"SELECT * FROM $this->table_name where userid = '$userid'"
			);

			return $this->db->resultSet();
		}



		public function get_finish($dailytaskid)
		{
			$userid = Session::get('USERSESSION')['id'];

			$this->db->query(
				"SELECT * FROM $this->table_name 
					left join tasks as tasks 

					on tasks.id = $this->table_name.taskid

					where userid = '$userid'

					and tasks.dailytaskid = '$dailytaskid'"
			);

			return $this->db->resultSet();
		}

		public function get_task_histories()
		{
			return $this->get_list();
		}

		public function get_unfinish($dailytaskid)
		{
			$this->db->query(
				"SELECT * FROM tasks where id not in( SELECT taskid from $this->table_name) 
				and dailytaskid = '$dailytaskid'"
			);

			return $this->db->resultSet();
		}

		public function get_task_list($dailytaskid)
		{
			$this->db->query(
				"SELECT * FROM tasks where dailytaskid = '$dailytaskid'"
			);

			return $this->db->resultSet();
		}

		public function get_current_daily_task()
		{
			$finishDailyTask = $this->get_last_finished_daily_task();

			if(empty($finishDailyTask))
			{
				/*get the veryfirst daily task*/
				$this->db->query(
					"SELECT * from daily_tasks order by id asc limit 1"
				);

				return $this->db->single();
			}else{
				/*get the next task*/

				$this->db->query(
					"SELECT * FROM daily_tasks where startdate > '$finishDailyTask->date' order by startdate asc limit 1"
				);

				return $this->db->single();
			}
		}


		private function get_last_finished_daily_task()
		{
			$userid = Session::get('USERSESSION')['id'];

			$this->db->query(
				"	SELECT * FROM users_daily_task_finished 
					where userid = '$userid' 
					order by id desc limit 1"
			);

			return $this->db->single();
		}

		public function add_finish_task($taskid , $userid)
		{
			$this->db->query(
				"INSERT INTO users_daily_task_finished(userid , dailytaskid , date)
				(SELECT '$userid', id , startdate from daily_tasks where id = '$taskid')"
			);

			if($this->db->execute()) 
			{
				Flash::set('Next Task');
				redirect('dailytask/todos');
			}else{
				Flash::set('Something wentwrong' , 'danger');
				redirect('dailytask/todos');
			}
		}
	}