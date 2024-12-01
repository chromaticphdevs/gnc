<?php 	
	
	require_once FNCTNS.DS.'crawler.php';

	class BinaryReverse extends Controller
	{
		public function __construct()
		{
			$this->binary = model('Binary_model');
		}

		public function index($userid)
		{

			$crawlers = crawler_upline($userid);

			$this->printTableTwo($crawlers);
			
			// $results = $this->binary->getReverse($userid);

			// $this->printTable($results);
			
		}


		private function printTableTwo($results)
		{
			$tr = '';

			if(!empty($results))
			{
				$counter = 0;
				foreach($results as $key => $row) 
				{
					$counter++;
					$tr .= '<tr>';
						$tr.= "<td>{$counter}</td>";
						$tr.= "<td>{$row->id}</td>";
						$tr.= "<td>{$row->firstname}</td>";
						$tr.= "<td>{$row->lastname}</td>";
						$tr.= "<td>{$row->username}</td>";
						$tr.= "<td>{$row->upline}</td>";
						$tr.= "<td>{$row->position}</td>";
					$tr .= '</tr>';
				}
			}

			print <<<EOF
				<table cellpadding='12' border:'1'> 
					<thead>
						<th>Counter</th>
						<th>ID</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Username</th>
						<th>Upline</th>
						<th>Position</th>
					</thead>
					<tbody>
						{$tr}
					</tbody>
				</table>
			EOF;
		}

		private function printTable($results)
		{
			$tr = '';

			if(!empty($results))
			{
				$counter = 0;
				foreach($results as $key => $row) 
				{
					$counter++;
					$tr .= '<tr>';
						$tr.= "<td>{$counter}</td>";
						$tr.= "<td>{$row->id}</td>";
						$tr.= "<td>{$row->firstname}</td>";
						$tr.= "<td>{$row->lastname}</td>";
						$tr.= "<td>{$row->username}</td>";
						$tr.= "<td>{$row->upline}</td>";
						$tr.= "<td>{$row->L_R}</td>";
					$tr .= '</tr>';
				}
			}

			print <<<EOF
				<table cellpadding='12' border:'1'> 
					<thead>
						<th>Counter</th>
						<th>ID</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Username</th>
						<th>Upline</th>
						<th>Position</th>
					</thead>
					<tbody>
						{$tr}
					</tbody>
				</table>
			EOF;
		}	
	}