<?php build('content')?>

	<div class="card">
		<div class="card-header">
			<h4>Geneology Wide</h4>
		</div>

		<div class="card-body">
			<table class="table">
				<thead>
					<th>#</th>
					<th>Username</th>
					<th>LEFT</th>
					<th>RIGHT</th>
					<th>USERID</th>
				</thead>

				<tbody>
					<?php foreach($geneology as $key => $row) :?>
						<?php if($row->uplines <= 2) break;?>
						<tr>
							<td><?php echo ++$key?></td>
							<td><?php echo $row->username?></td>
							<td><?php echo $row->uplineLeft->total ?? 0?></td>
							<td><?php echo $row->uplineRight->total ?? 0?></td>
							<td><?php echo $row->upline_id?></td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>