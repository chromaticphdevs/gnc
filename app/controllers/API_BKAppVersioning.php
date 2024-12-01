<?php 	

	class API_BKAppVersioning extends Controller
	{

		public function __construct()
		{
			$this->model = model('BKAppVersioningModel');
		}

		public function getByKey()
		{
			$versionKey = request()->input('versionKey');

			$versionKey = trim($versionKey);
			
			$request = $this->model->getByKey($versionKey);

			$latest  = $this->model->getLatest();

			return ee(api_response( [
				'query' => $request,
				'latest' => $latest
			] ));
		}
	}