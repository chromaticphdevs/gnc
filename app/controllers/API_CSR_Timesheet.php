<?php 	

	class API_CSR_Timesheet extends Controller
	{
		public function __construct()
		{
			$this->model = model('CSR_TimesheetModel');

			$this->NewUserFollowUp = model('NewUserFollowUpModel');
			$this->followUp = model('FollowUpModel');
			$this->toc = model('TOCModel');
			$this->CallCenter = model('CallCenterModel');

		}

		public function get()
		{
			//total
			$q = request()->inputs();

			$userId = $q['userId'];
			$userType = $q['userType'];

			$total = $this->model->getTotalAmount( $userId , $userType);

			$data = [
				'followUpSummary' => $this->followUp->getUserSummary($userId),
				'tocSummary'      => $this->toc->getUserSummary($userType),
				'NewUserFollowUp' => $this->NewUserFollowUp->getUserSummary($userId),
				'total'  => $total,
			];

			
			ee(api_response($data));
		}

		// public function
	}

	