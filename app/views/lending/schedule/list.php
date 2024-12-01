<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">

	<main class="ui container">
		<div class="ui inverted menu">
		  <a class="active item">
		    Home
		  </a>
		  <a class="item">
		    Messages
		  </a>
		  <a class="item">
		    Friends
		  </a>
		</div>
		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<section class="ui segment">
					<h3>Schedule Info</h3>
					<?php $detail = $schedule['detail'];?>
					<ul>
						<li><?php echo $detail->date?></li>
						<li><?php echo $detail->time?></li>
						<li><?php echo $detail->grace_time?></li>
						<li><?php echo date_formatter([$detail->date , $detail->time] , 'long')?></li>
					</ul>
					<?php unset($detail)?>
				</section>

				<section class="ui segment">
					<h3>Add Attendees</h3>

					<section class="ui segment">
						<table class="ui table">
							<thead>
								<th>#<input type="checkbox"></th>
								<th>Full Name</th>
								<th>Arrival Time</th>
								<th>Arrival Date</th>
								<th>Schedule</th>
								<th>Remarks</th>
							</thead>

							<tbody>
								<?php foreach($schedule['attendeeList'] as $key => $row ) :?>
									<tr>
										<td><?php echo ++$key?></td>
										<td><?php echo $row->userid?></td>
										<td><?php echo get_time_long($row->arrival_time)?></td>
										<td><?php echo get_date_long($row->arrival_date)?></td>
										<td><?php echo get_time_long($row->sched_time)?></td>
										<td><?php echo $row->remarks?></td>
									</tr>
								<?php endforeach?>
							</tbody>
						</table>

						<button class="ui button"> Add Attendees </button>
					</section>
					<section class="ui segment">
						<h4>Attendee List</h4>
						<table class="ui table">
							<thead>
								<th>#<input type="checkbox"></th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Picture</th>
							</thead>

							<tbody>
								<?php foreach($user['onbranch'] as $key => $row ) :?>
									<tr>
										<td><input type="checkbox"><?php echo ++$key?></td>
										<td><?php echo $row->fullname?></td>
										<td><?php echo $row->email?></td>
										<td><?php echo 'sample pcture'?></td>
									</tr>
								<?php endforeach?>
							</tbody>
						</table>
					</section>
				</section>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
