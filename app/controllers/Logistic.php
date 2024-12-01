<?php 	
	class Logistic extends Controller
	{

		public function __construct()
		{
			$this->model = model('LogisticModel');
		}

		public function show($id)
		{
			$logistic = $this->model->getCompleteAndAPI($id);

			return $this->view('logistic/show', compact(['logistic']));
		}
	}