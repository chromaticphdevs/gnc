<?php build('content') ?>
	<h4>Users</h4>
	<?php Flash::show()?>
	<div>
		<a href="?user_status=with_accounts">Registered</a> | 
		<a href="?user_status=without_accounts">Un Registered</a>
	</div>
	<?php if( isEqual($userStatus , 'with_accounts') ) :?>
		<table class="table">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th>Type</th>
				<th>Rate Per Day</th>
				<th>Work Hours</th>
				<th>Wallet</th>
				<th>Pera-E Account</th>
				<th>Action</th>
			</thead>

			<tbody>
				<?php foreach($users as $key => $row) :?>
					<tr>
						<td><?php echo ++$key?></td>
						<td>
							<?php echo $row->firstname.' '.$row->lastname?>
							<div>(<?php echo $row->username?>)</div>
						</td>
						<td><?php echo $row->type?></td>
						<td><?php echo to_number($row->rate_per_day)?></td>
						<td><?php echo $row->work_hours?></td>
						<td><?php echo to_number($row->wallet)?></td>
						<td>
							<?php
								if(isEqual($row->pera_account_number , 0 )) 
								{
									echo 'no pera-e account';
								}else{
									echo '<div>'.$row->pera_account_number.'</div>';
								}
							?>
						</td>
						<td>
							<a href="/timekeeping/edit/<?php echo $row->domain_user_token?>" class="btn btn-sm btn-primary">Edit</a> 
							<a href="/TKUser/show/<?php echo $row->domain_user_token?>" class="btn btn-sm btn-primary">Show</a>
							<a href="/timekeeping/deleteAppData/<?php echo $row->domain_user_token?>&
								token=<?php echo $tkAppSession?>" class="btn btn-sm btn-danger form-confirm">Delete</a>
						</td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
	<?php endif;?>


	<?php if(isEqual($userStatus , 'without_accounts')) :?>
		<table class="table">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th>Timekeeping ID</th>
				<th>Action</th>
			</thead>

			<tbody>
				<?php foreach($users as $key => $row) :?>
					<tr>
						<td><?php echo ++$key?></td>
						<td><?php echo $row->name?></td>
						<td><?php echo $row->tk_acces_key ?? 'No Access Key'?></td>
						<td><a href="/timekeeping/register/<?php echo $row->id?>">Register</a></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
	<?php endif;?>
<?php endbuild() ?>
<?php occupy('templates/layout');