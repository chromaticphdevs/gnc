<?php build('content') ?>
	
	<div class='row'>
		<div class="col-md-6">
			<a href="/FNAccount/loan_payments_info"> <i class="fa fa-back-arrow"></i> Return</a>
			<h3>Reference : <?php echo $logistic->carrier->reference?></h3>

			<dl>
				<dt> <strong>Delivery Address</strong></dt>
				<dd><?php echo $logistic->carrier->address?></dd>

				<dt> <strong>Status</strong> </dt>
				<dd><?php echo $logistic->carrier->status?></dd>
			</dl>

			<h4>Owner</h4>
			<ul>
				<li>Billed to : <?php echo $logistic->shipment->user->firstname . ' '.$logistic->shipment->user->lastname?></li>
				<li>Mobile : <?php echo $logistic->shipment->user->mobile?></li>
				<li>Address : <?php echo $logistic->shipment->user->address?></li>
			</ul>
			<h4>Parcel : <?php echo $logistic->shipment->parcel->name?> Package (<?php echo $logistic->shipment->parcel->box_eq?>) Boxes </h4>
		</div>
	</div>
<?php endbuild()?>

<?php occupy('templates/layout')?>