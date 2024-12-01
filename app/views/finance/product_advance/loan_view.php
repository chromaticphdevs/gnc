<?php build('content')?>
	<h3>Payment</h3>
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
	    <td><?php Form::file('payment_picture' , $input['required'])?></td>
	  </tr>
	</table>

	<div>
		<table class="table">
			<tr>
				<td>Product Amount</td>
				<td><?php echo $loan->amount?> ($loanPayment->productPayment)</td>
			</tr>
			<tr>
				<td>Delivery Fee</td>
				<td><?php echo $loan->delivery_fee?> ($loanPayment->deliveryPayment)</td>
			</tr>

			<tr>
				<td>Balance:</td>
				<td><?php ($loan->amount + $loan->delivery_fee) - ($loanPayment->productPayment + $loanPayment->productPayment)?></td>
			</tr>

			<tr>
				<td>Make Payment</td>
				<td>
					<?php
						Form::text('amountPayment' , '' , [
							'class' => 'form-control'
						]);
					?>
					<label for="amountRadio">
						<input type="radio" name="paymentFor" id="amountRadio" value="amount">
						Amount
					</label>

					<label for="deliveryRadio">
						<input type="radio" name="paymentFor" id="deliveryRadio" value="delivery">
						Delivery
					</label>
				</td>
			</tr>
		</table>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>