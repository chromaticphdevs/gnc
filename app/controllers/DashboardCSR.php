<?php 	

	class DashboardCSR extends Controller
	{
		public function __construct()
		{	
			$this->NewUserFollowUp = model('NewUserFollowUpModel');
			$this->followUp = model('FollowUpModel');
			$this->toc = model('TOCModel');
			$this->CallCenter = model('CallCenterModel');
		}

		public function index()
		{
			check_session();

			$auth = whoIs();

			$check_access_gsm = $this->CallCenter->check_access($auth['id']);
			

			$data = [
				'followUpSummary' => $this->followUp->getUserSummary($auth['id']),
				'tocSummary'      => $this->toc->getUserSummary($auth['id']),
				'NewUserFollowUp' => $this->NewUserFollowUp->getUserSummary($auth['id']),
				'check_access_gsm' => $check_access_gsm,
				'gsm_device' => $this->CallCenter->get_all_device(),
				'user_id' => seal($auth['id'])
			];

			return $this->view('dashboard/csr' , $data);
		}
	}