	<?php 	

	class LDClass extends Controller
	{


		private $view = 'lending/';

		public function __construct()
		{
			$this->classModel = $this->model('LDClassModel');

				
		}
		public function create()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');
			if($this->request() === 'POST'){

				$this->classModel->create($_POST);

			}else{

				$this->view($this->view.'class/create');
			}
		}

		public function updateClass()
		{
			
			$data = [
				'classList' => $this->classModel->list()
			];

				$this->view($this->view.'class/change_group',$data);
		}	

		public function updateClass_info($classId)
		{		
			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');

			$classInfo  = $this->classModel->view($classId);


			$data =[
				'classInfo' =>  $classInfo
			];
			$this->view($this->view.'class/update',$data);
		
		}


		public function updateInfo()
		{

		
	     $class  = $this->classModel->update($_POST);

		}


		public function list()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');
			$data = [
				'classList' => $this->classModel->list()
			];

			$this->view($this->view.'class/list' , $data);
		}



		public function preview($classid)
		{
			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');
			
			$class  = $this->classModel->view($classid);
			$classList  = $this->classModel->classlist($classid);
			$noClass  = $this->classModel->noClass();
			$conflict  = $this->classModel->conflict_ClassList($classid,$class->day);
			$scheduleOnCurrentDate = getDayMonthOccurence(date('m') ,dayNumericToShort( $class->day ));
		
			$data =[
				'classId' => $classid,
				'class' =>  $class,
				'classList' => $classList,
				'noClass' => $noClass,
				'schedule' => $scheduleOnCurrentDate,
				'conflict' =>$conflict
			];

			$this->view($this->view.'class/preview', $data);
		}

		public function add_user()
		{
		
	     $class  = $this->classModel->addLender($_GET);

		}
			public function update_user_class()
		{
	  	 $class  = $this->classModel->update_user($_POST);
		}




	}