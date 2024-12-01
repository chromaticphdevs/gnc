<?php 	
	
	class TimesheetTrash extends Controller
	{

		public function __construct()
		{
			$this->tkapp = model('TimekeepingAppModel');
		}

		public function index()
		{
			$responseData = $this->tkapp->getTrash();

			$tkAppSession = $this->tkapp->session;

			$timesheets = [];

			if($responseData->data) 
				$timesheets = $responseData->data;

			return $this->view('timekeeping/trash/index' , compact(['timesheets' , 'tkAppSession']));
		}

		public function bulkAction()
		{
			$timesheets = request()->input('timesheetIds');

			$bulkAction = request()->input('action');

			$apiParams = [
				'timesheetIds' => $timesheets
			];

			if(empty($timesheets)) {

				Flash::set("You must select atleast 1 row of timesheet" , 'danger');
				return request()->return();
			}

			if(isEqual($bulkAction , 'Restore'))
			{
				Flash::set("Timesheets restored");
				$this->tkapp->restore($apiParams);
			}

			if(isEqual($bulkAction , 'Move to Trash')){
				Flash::set("Timesheets restored");
				$this->tkapp->moveToTrash($apiParams);
			}

			return redirect('TimesheetTrash');
		}

		public function moveToTrash()
		{
			$post = request()->inputs();

			$apiParams = [
				'timesheetIds' => $post['timesheetIds']
			];


			$result = $this->tkapp->moveToTrash($apiParams);

			if($result) {
				Flash::set("Moved to trash");
			}
			return request()->return();
		}

		public function restore()
		{
			$timesheetId = request()->input('timesheetIds');

			$apiParams = [
				'timesheetIds' => $timesheetId
			];

			$result = $this->tkapp->restore($apiParams);


			if($result) {
				Flash::set("Restored");
			}

			return request()->return();
		}
	}