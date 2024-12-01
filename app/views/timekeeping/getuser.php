<?php build('content') ?>

<div class="card">
	<div class="card-header">
		<h4><?php echo $account->firstname . ' ' . $account->lastname?></h4>
		<a href="/timekeeping/getUsers">Return</a>
	</div>

	<div class="card-body">
		<h4>
			Wallet <strong>PHP <?php echo to_number($account->wallet)?></strong>
		</h4>

		<a href="/TimekeepingStory/index?userToken=<?php echo $account->domain_user_token?>" target="_blank">Timesheet Story</a>

		<a href="/TimekeepingStory/expanded/?userToken=<?php echo $account->domain_user_token?>">Timesheet Story Expanded</a>
		<section class="x_panel">
			<div class="x_panel_body">
				<h3>Timesheets</h3>
				<?php if($timesheets) :?>
				<div class="table-responsive">
				    <table class="table">
				        <thead>
				            <th>#</th>
				            <th>Time In</th>
				            <th>Time Out</th>
				            <th>Duration</th>
				            <th>Rate</th>
				            <th>Allowance</th>
				            <th>Status</th>
				        </thead>

				        <tbody>
				            <?php foreach($timesheets as $key => $row): ?>
				            <tr>
				                <td><?php echo ++$key?></td>
				                <td><?php echo get_date($row->time_in , 'M d,Y h:i:s A')?></td>
				                <td><?php echo get_date($row->time_out, 'M d,Y h:i:s A')?></td>
				                <td><?php echo $row->duration?> mins</td>
				                <td><?php echo $row->meta->rate?></td>
				                <td><?php echo $row->amount?></td>
				                <td><?php echo $row->status?></td>
				            </tr>
				            <?php endforeach?>
				        </tbody>
				    </table>
				</div>
				<?php else : ?>
					<h4>No Timesheets for the moment</h4>
				<?php endif;?>
			</div>
		</section>

		<section class="x_panel">
			<h3>Wallets</h3>
			<table class="table text-right">
				<thead>
					<th>#</th>
					<th>Description</th>
					<th>Date</th>
					<th>Amount</th>
				</thead>

				<tbody>
					<?php foreach($wallets as $key => $wallet) :?>
						<tr>
							<td><?php echo ++$key?></td>
							<td><?php echo $wallet->description?></td>
							<td><?php echo date_long($wallet->created_at , 'M d,Y h:i:s A')?></td>
							<td><?php echo to_number($wallet->amount)?></td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</section>
	</div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>