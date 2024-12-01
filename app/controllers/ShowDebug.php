<?php 	

	class ShowDebug extends Controller
	{
		public function index()
		{
			Debugger::show_logs();
		}
	}