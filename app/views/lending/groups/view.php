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
				<h3>Create Group</h3>
				<section class="ui segment">
					<h3>Group Info</h3>

					<ul>
						<li><?php echo $group['detail']->group_name?></li>
						<li><?php echo $group['detail']->branchid?></li>
					</ul>

				</section>

				<section class="ui segment">
					<h3>Schedules</h3>

					<section class="ui segment">
						<h4>Create Schedule</h4>
						<form class="ui form" action="/LDSchedule/create_schedule" method="post">
							<input type="hidden" name="groupid" value="<?php echo $group['detail']->id?>">
							<div class="field">
								<label for="#">Date</label>
								<input type="date" name="date" class="form-control">
							</div>

							<div class="field">
								<label for="#">Time</label>
								<input type="time" name="time" class="form-control">
							</div>

							<div class="field">
								<label for="#">Grace Time</label>
								<div class="fields">
									<div class="three wide field"><input type="text" name="grace_time[hour]" placeholder="Hour :" value="00">
										<small>Hour</small>
									</div>
									<div class="three wide field"><input type="text" name="grace_time[min]" placeholder="Min :" value="30">
										<small>Min</small>
									</div>
									<div class="three wide field"><input type="text" name="grace_time[sec]" placeholder="Sec :" value="00">
										<small>Sec</small>
									</div>
								</div>
							</div>

							<input type="submit" class="ui button" value="Create Schedule">
						</form>
					</section>

					<section class="ui segment">
						<h4>Schedule List</h4>
						<table class="table">
							<thead>
								<th>Date</th>
								<th>Time</th>
								<th>Description</th>
								<th>Grace Time</th>
								<th>Attendees</th>
								<th>Actions</th>
							</thead>

							<tbody>
								<?php foreach($group['schedules'] as $row) :?>
									<tr style="<?php echo $row->status == 'active' ? 'background: #708238' : ''?>">
										<td><?php echo $row->date?></td>
										<td><?php echo $row->time?></td>
										<td><?php echo date_formatter([$row->date , $row->time] , 'long');?></td>
										<td><?php echo $row->grace_time?></td>
										<td><a href="/LDScheduleAtendee/get_list?scheduleid=<?php echo $row->id?>" style="color:black">View</a></td>
										<td>
											<form class="ui form" action="/LDSchedule/update_schedule" method="post">
												<input type="hidden" name="scheduleid" value="<?php echo $row->id?>">
												<input type="hidden" name="groupid" value="<?php echo $groupid?>">
												<div class="field">
													<select name="status" id="">
														<?php foreach($scheduleStatus as $schedule) :?>
															<?php $selected = $schedule == $row->status ? 'selected' : ''?>
															<option value="<?php echo $schedule?>" <?php echo $selected?>>
																<?php echo ucfirst($schedule)?>
															</option>
														<?php endforeach?>
													</select>
												</div>
												<input type="submit" value="Update">
											</form>
										</td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</section>
				</section>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
