<?php build('content')?>
	<h3>Payment</h3>
	<?php 
		Form::open([
			'method' => 'post',
			'action' => '/ProductLoan/makePayment',
			'enctype' => 'multipart/form-data'
		]);
	?>
	<table class="table">
	  <tr>
	    <td>Fullname:</td>
	    <td><strong><?php echo $userInfo->fullname; ?></strong></td>
	  </tr>

	  <tr>
	    <td>Status/Level</td>
	    <td><strong><?php echo $userInfo->status; ?></strong></td>
	  </tr>

	  <tr>
	    <td>Email:</td>
	    <td><strong><?php echo $userInfo->email; ?></strong></td>
	  </tr>
	  <tr>
	    <td>Mobile Number:</td>
	    <td><strong><?php echo $userInfo->mobile; ?></strong></td>
	  </tr>
	  <tr>
	    <td>Upload Image</td>
	    <td><?php Form::file('payment_picture', [
	    		'required' => ''
	    	])?></td>
	  </tr>
	</table>

	<div>
		<table class="table">
			<tr>
				<td>Product Amount</td>
				<td><strong>To Pay : <?php echo to_number($loan->amount - $loanPayment['productAmount'])?></strong> <?php echo $loan->amount . "({$loanPayment['productAmount']})"?> </td>
			</tr>
			<tr>
				<td>Delivery Fee</td>
				<td> <strong>To Pay: <?php echo $loan->delivery_fee - $loanPayment['deliveryAmount']?></strong> <?php echo $loan->delivery_fee."({$loanPayment['deliveryAmount']})"?></td>
			</tr>

			<tr>
				<td>Balance:</td>
				<td>
					<?php echo to_number($balance)?>
				</td>
			</tr>

			<tr>
				<td>Make Payment</td>
				<td>
					<?php
						Form::hidden('loan_id' , $loan->id);

						Form::hidden('balance' , $balance);
						//amount that will be given by the customer
						Form::text('amount_payment' , '' , [
							'class' => 'form-control',
							'required' => ''
						]);
					?>
					<label for="amountRadio">
						<input type="radio" name="payment_for" id="amountRadio" value="product" required>
						Product
					</label>

					<label for="deliveryRadio">
						<input type="radio" name="payment_for" id="deliveryRadio" value="delivery" required>
						Delivery
					</label>
				</td>
			</tr>

			<tr>
				<td>Note</td>
				<td>
					<?php
						Form::text('note' , '' , [
							'class' => 'form-control',
							'required' => ''
						]);
					?>
				</td>
			</tr>

			<tr>
				<td>
					<?php
						Form::submit('' , 'Make Payment' , [
							'class'=>'btn btn-primary btn-sm form-confirm' 
						]);
					?>
				</td>
			</tr>
		</table>
		<?php Form::close()?>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>