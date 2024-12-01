<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Loans</h4>
		</div>
		<div class="card-body">
			<table class="table table-bordered">
				<tr>
					<td><strong>Loan Reference:</strong></td>
					<td><?php echo $loan->loan_reference?></td>
				</tr>
				<tr>
					<td><strong>Date:</strong></td>
					<td><?php echo $loan->date_of_entry?></td>
				</tr>
				<tr>
					<td><strong>Loaned Amount:</strong></td>
					<td><?php echo $loan->initial_amount?></td>
				</tr>

				<tr>
					<td><strong>Balance:</strong></td>
					<td><?php echo $loan->balance?></td>
				</tr>

				<?php if(isset($product)) :?>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td>Product : </td>
						<td><?php echo $product['name']?></td>
					</tr>
					<tr>
						<td>Price : </td>
						<td><?php echo $product['amount']?></td>
					</tr>
					<tr>
						<td>Quantity : </td>
						<td><?php echo $loan->item_quantity?></td>
					</tr>
				<?php endif?>
			</table>
		</div>
	</div>
<?php endbuild()?>
<?php occupy()?>