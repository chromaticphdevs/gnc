<?php build('content')?>
	<h4>Call Logs</h4>

	<?php if(isset($_GET['filter'])) : ?>
		<a href="?">Cancel</a>
	<?php endif?>
	<table class="table">
		<thead>
			<th>User</th>
			<th>Income</th>
			<th>Call Duration</th>
			<th>Rate</th>
			<th>Work Hours</th>
		</thead>

		<tbody>
			<?php $payoutAmount = 0?>
			<?php foreach($results as $key => $row) : ?>
				<?php $payoutAmount += $row->amount?>
				<tr>
					<td>
						<a href="?filter=true&user=<?php echo $row->user_id?>"><?php echo $row->firstname  . ' ' . $row->lastname?></a>
					</td>
					<td><?php echo $row->amount?></td>
					<td><?php echo $row->duration?></td>
					<td><?php echo $row->rate?></td>
					<td><?php echo $row->work_hours?></td>
				</tr>
			<?php endforeach?>
		</tbody>
	</table>
	<h4> Payout Total : <?php echo $payoutAmount?></h4>
<?php endbuild()?>
<?php occupy('templates/layout')?>