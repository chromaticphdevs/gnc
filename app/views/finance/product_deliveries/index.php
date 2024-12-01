<?php build('content') ?>
	<h4 class="card-title">Deliveries</h4>

	<?php if(!empty($status)) :?>
		<a href="?">Cancel</a>
	<?php endif?>
	<div class="container">
		<table class="table">
			<thead>
				<th>#</th>
				<th>Reference</th>
				<th>Customer</th>
				<th>Address</th>
				<th>Status</th>
				<th>Item</th>
				<th>Loan</th>
			</thead>

			<tbody>
				<?php $counter = 1?>
				<?php foreach($deliveries as $deliveryKey => $delivery) : ?>
					<?php if( !empty($status) && !isEqual($delivery->status , $status)) continue;?>
					<tr>
						<td><?php echo $counter++?></td>
						<td><?php echo $delivery->reference?></td>
						<td><?php echo $delivery->full_name?></td>
						<td><?php echo $delivery->billing_address?></td>
						<td>
							<a href="?status=<?php echo $delivery->status?>"><?php echo $delivery->status?></a>
						</td>
						<td>
							<?php foreach($delivery->items as $itemKey => $item) :?>
								<div><?php echo $item->item_name?></div>
							<?php endforeach?>
						</td>
						<td>
							<a href="/ProductDeliveries/update?delivery_id=<?php echo $delivery->id?>&action=delivered" class="btn btn-primary btn-sm">Delivered</a>
							<a href="/ProductDeliveries/update?delivery_id=<?php echo $delivery->id?>&action=returned" class="btn btn-primary btn-sm">Return</a>
						</td>
					</tr>
					<tr>
						<td colspan="7">
							<ul>
								<li>Loan Code : <?php echo $delivery->loan->code?></li>
								<li>Delivery Fee:<?php echo $delivery->loan->delivery_fee?> </li>
								<li>Quantity: <?php echo $delivery->loan->quantity?></li>
								<li>Amount : <?php echo $delivery->loan->amount?></li>
							</ul>
						</td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>