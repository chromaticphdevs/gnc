<?php build('content') ?>

	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Shipment Search</h4>
			</div>

			<div class="card-body">
				<?php Form::open(['method' => 'GET'])?>
					<div class="form-group">
						<?php
							Form::label('Control Number');
							Form::text('control_number' , '' , [
								'class' => 'form-control'
							]);
						?>
					</div>

					<div class="form-group">
						<?php Form::submit('' , 'Search' , ['class' => 'btn btn-primary btn-sm']) ?>
					</div>
				<?php Form::close()?>
			</div>
		</div>
	</div>


	<?php if(isset($shipment) && $shipment) :?>
		<hr>
		<div class="col-md-12">
			<h2>Searched Shipment</h2>
			<div class="row">
				<div class="col-md-4">
					<div class="loan-information">
						<ul>
							<li><h3>Loan Details</h3></li>
							<li>Code : <?php echo $shipment->loan->code?></li>
							<li>Product  : <?php echo $shipment->loan->product_name?></li>
							<li>Amount  : <?php echo $shipment->loan->amount?></li>
							<li>Quantity  : <?php echo $shipment->loan->quantity?></li>
							<li>Delivery Fee  : <?php echo $shipment->loan->delivery_fee?></li>
							<li>Status : <?php echo $shipment->loan->status?></li>
							<li>Category  : <?php echo $shipment->loan->category?></li>

							<li> Created At : <?php echo $shipment->loan->date_time?> Updated At : <?php echo $shipment->loan->updated_at?></li>
						</ul>

						<?php echo wProductLoanMakePaymentBtn($shipment->loan->id) ?>
					</div>
				</div>

				<div class="col-md-4">
					<ul>
						<li><h3>Shipment Details</h3></li>
						<li>Control Number : <?php echo $shipment->control_number?></li>
						<li>Created At : <?php echo $shipment->date_time?></li>
					</ul>
				</div>

				<div class="col-md-4">
					<ul>
						<li><h3>User</h3></li>
						<li>Name: <?php echo $shipment->user->fullname?></li>
						<li>Mobile : <?php echo $shipment->user->mobile?></li>
						<li>Address : <?php echo $shipment->user->address?></li>
					</ul>
				</div>
			</div>
		</div>
	<?php endif?>


	<?php if( isset($shipment) && !$shipment ) :?>
		<div class="col-md-12">
			<h1 class="text-center"> Shipment Not Found</h1>
		</div>
	<?php endif?>
<?php endbuild()?>
<?php occupy('templates/layout')?>