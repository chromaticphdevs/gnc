<?php build('content') ?>
	<div class="container">
		<div class="card-header">
			<h4 class="card-title"> Toc on Stand By</h4>
		</div>

		<div class="card-body">
			<table class="table">
				<thead>
					<th>#</th>
					<th>Username</th>
					<th>Fullname</th>
					<th>Mobile</th>
					<th>Address</th>
					<th>Email</th>
					<th>Remove to Stand By</th>
				</thead>

				<tbody>
					<?php $counter = 1;?>
					<?php foreach($tocPassers as $key => $toc) : ?>
						<?php if( empty($toc->user) ) continue?>
						<?php $user = $toc->user?>
						<tr>
							<td><?php echo $counter++?></td>
							<td><?php echo $user->username ?? 'xxxxxxx'?></td>
							<td><?php echo $user->firstname ?? 'xxxxxxx' . ' ' .$user->lastname ?? 'xxxxxxx'?></td>
							<td><?php echo $user->mobile ?? 'xxxxxxx'?></td>
							<td><?php echo $user->address ?? 'xxxxxxx'?></td>
							<td><?php echo $user->email ?? 'xxxxxxx'?></td>
							<td>
								<a href="/TocController/remove_to_standby/<?php echo seal($user->id)?>" class="btn btn-primary btn-sm">Remove to stand by</a>
							</td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>