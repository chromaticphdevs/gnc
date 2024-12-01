<?php build('content')?>
	<h2><?php echo $account->firstname . ' ' . $account->lastname?></h2>
	<h3>Wallet : <?php echo to_number($account->wallet)?></h3>
	<section class="well">
		<div>Rate : <?php echo $account->rate_per_day?> | 
		Work Hours : <?php echo $account->work_hours?> | 
		Max Work Hours : <?php echo $account->max_work_hours?></div>
		<div class="row">
			<div class="col-md-5">
				<h4>Work Hours Today</h4>
				<?php echo $parsed['workHoursToday']?>
			</div>

			<div class="col-md-5">
				<h4>Pending Timesheets</h4>
				<?php echo $parsed['pendingTimesheets']?>
			</div>
		</div>
	</section>

	<section>
		<h4>Timesheets</h4>

		<div class="well">
			<?php
				$today = get_date(today() , 'M d Y');
				$tsheetCounter = 0;
			?>

			<?php foreach($parsed['timesheetsGrouped'] as $key => $timesheets) :?>
				<?php
					$duration = 0;
					$className = uniqid('cs');

					$isToday = isEqual($today , $key);

					$tsheetCounter ++;


					if($tsheetCounter > 5)
						break;
				?>
				<section class="container-box">
					<a href="#" data-target=".<?php echo $className?>" class='tbody-toggle'>Show Data</a>
					<h4><?php echo ucwords($key)?></h4>
					<table class="table <?php echo $className?> <?php echo $isToday == true ? '': 'tbodyHidden'?> ">
						<thead>
							<th>#</th>
							<th>Time In</th>
							<th>Time Out</th>
							<th>Duration</th>
							<th>Amount</th>
							<th>Allowance</th>
							<th>Status</th>
						</thead>

						<tbody>
							<?php foreach($timesheets as $tsheet) :?>
								<?php $duration += $tsheet->duration?>
								<tr>
									<td>#</td>
									<td><?php echo $tsheet->time_in?></td>
									<td><?php echo $tsheet->time_out?></td>
									<td><?php echo $tsheet->duration?></td>
									<td><?php echo $tsheet->meta->rate?></td>
									<td><?php echo $tsheet->amount?></td>
									<td><?php echo $tsheet->status?></td>
								</tr>
							<?php endforeach?>
						</tbody>
					</table>
					
					<h4>Work hours Rendered : <?php echo minutesToHours($duration) ?></h4>
				</section>
			<?php endforeach?>

			<?php if( count($parsed['timesheetsGrouped']) > $tsheetCounter ) :?>
				<a href="<?php echo $showAll?>">Show all</a>
			<?php endif?>
		</div>
	</section>

	<section>
		<h4>Wallets</h4>

		<div class="well">
			<h2>Payouts</h2>
			<?php foreach($parsed['wallets']['payouts'] as $key => $row) :?>
				<section class="container">
					<table class="table">
						<thead>
							<th>#</th>
							<th>Amount</th>
							<th>Description</th>
							<th>Created at</th>
						</thead>

						<tbody>
							<tr>
								<td><?php echo ++$key?></td>
								<td><?php echo $row->amount?></td>
								<td><?php echo $row->description?></td>
								<td><?php echo $row->created_at?></td>
							</tr>
						</tbody>
					</table>
				</section>
			<?php endforeach?>
		</div>

		<div class="well">
			<h2>Transactions</h2>
			<?php $wcounter = 0?>
			<?php foreach($parsed['walletsGrouped'] as $key => $wallets) :?>
				<?php
					$duration = 0;
					$className = uniqid('cs');

					$isToday = isEqual($today , $key);

					$wcounter ++;

					if($wcounter > 5)
						break;
				?>

				<section class="container-box">
					<a href="javascript:void(0)" data-target=".<?php echo $className?>" class='tbody-toggle'>Show Data</a>
					<h4><?php echo ucwords($key)?></h4>
					<table class="table <?php echo $className?> <?php echo $isToday == true ? '': 'tbodyHidden'?> ">
						<thead>
							<th>#</th>
							<th>Description</th>
							<th>Date</th>
							<th>Amount</th>
						</thead>

						<tbody>
							<?php foreach($wallets as $wallet) :?>
								<?php $duration += $tsheet->duration?>
								<tr>
									<td>#</td>
									<td><?php echo $wallet->description?></td>
									<td><?php echo get_date($wallet->created_at , 'M d Y')?></td>
									<td><?php echo to_number($wallet->amount)?></td>
								</tr>
							<?php endforeach?>
						</tbody>
					</table>
				</section>
			<?php endforeach?>	

			<?php if( count($parsed['walletsGrouped']) > $wcounter ) :?>
				<a href="<?php echo $showAll?>">Show all</a>
			<?php endif?>
		</div>
	</section>
<?php endbuild()?>

<?php build('headers')?>
	<style type="text/css">
		.tbodyHidden{
			display: none;
		}

		.container-box{
			border: 1px solid #000;
			margin-bottom: 5px;

			padding: 15px;
		}
	</style>
<?php endbuild()?>

<?php build('scripts')?>

	<script type="text/javascript">
		$( document ).ready(function() {

			$('.tbody-toggle').click( function(evt) 
			{
				let target = $(this).data('target');

				$(target).toggle();
			});
		});
	</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>