<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Loans</h4>
			<a href="/LoanUniversalController/create">Create Loan</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<th>#</th>
						<th>Reference</th>
						<th>Benefeciary</th>
						<th>Amount Loaned</th>
						<th>Balance</th>
						<th>Last Updated</th>
					</thead>

					<tbody>
						<?php foreach($loans as $key => $row) :?>
							<tr>
								<td><?php echo ++$key?></td>
								<td>#<?php echo $row->loan_reference?></td>
								<td><?php echo $row->loaner_name?></td>
								<td><?php echo $row->initial_amount?></td>
								<td><?php echo $row->balance?></td>
								<td><?php echo $row->last_update ?? $row->created_at?></td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php occupy()?>