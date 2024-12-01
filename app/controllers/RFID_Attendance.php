
<?php 	

	class RFID_Attendance extends Controller
	{	

		public function __construct()
		{
			$this->RFID_Attendance_Check_Modal = $this->model('RFID_Attendance_Check_Modal');	

		}

		public function index()
		{

			if($this->request() === 'POST') 
			{
				redirect("RFID_Attendance/take_pic/?UID={$_POST['UID_code']}");

			}else{

				$this->view('/rfid_scanning/attendance');
			}
			

		}

		public function take_pic()
		{

			if($this->request() === 'POST') 
			{
				$this->RFID_Attendance_Check_Modal->attendance_check($_POST);

			}else{

				$this->view('/rfid_scanning/take_pic_attendance');
			}

		}


	}




