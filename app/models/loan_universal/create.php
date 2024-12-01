<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Loan</h4>
		</div>

		<div class="card-body">
			<div class="col-md-5">
				<?php
					Form::open([
						'method' => 'post',
						'action' => ''
					]);
				?>
					<div class="form-group">
						<?php
							Form::label('Benefeciary Username');
							Form::text('loaner_name', '', [
								'class' => 'form-control',
								'required' => true
							]);
						?>
					</div>

					<div class="form-group">
						<label>
							<input type="radio" name="loan_type" value="cash_loan" checked>
							Cash Loan
						</label>

						<label>
							<input type="radio" name="loan_type" value="item_loan">
							Item Loan
						</label>
					</div>
					<div id="productLoanContainer">
						<div class="form-group">
							<?php Form::label('Product');?>
							<select name="product_id" class="form-control action-listener" id="productID">
								<option value="">--Select-</option>
								<?php
									foreach($products as $key => $row) {
										?> 
											<option value="<?php echo $key?>" 
												data-amount="<?php echo $row['amount']?>">
												<?php echo $row['name']?></option>
										<?php
									}
								?>
							</select>
						</div>

						<div class="form-group">
							<?php
								Form::label('Item Quantity');
								Form::text('item_quantity', 1, [
									'class' => 'form-control action-listener',
									'required' => true,
									'id' => 'itemQuantity'
								]);
							?>
						</div>
					</div>

					<div class="form-group">
						<?php
							Form::label('Amount');
							Form::text('amount', '', [
								'class' => 'form-control',
								'required' => true,
								'id' => 'amountID'
							]);
						?>
					</div>

					<div class="form-group">
						<?php Form::submit('', 'Apply Loan', [
							'class' => 'btn btn-primary btn-sm'
						]) ?>
					</div>
				<?php Form::close()?>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php build('scripts')?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#productLoanContainer").hide();

			let HTML_amount = $("#amountID");
			let HTML_product = $("#productID");


			$("input[name='loan_type']").change(function(e){
				if(e.target.value == 'item_loan') {
					$("#productLoanContainer").show();
				}else{
					$("#productLoanContainer").hide();
				}
			});


			$(".action-listener").change(function(e){
				calculateProductAmount();
			});


			function calculateProductAmount() {
				let amount = $("#productID :selected").data('amount');
				let product = HTML_product.val();
				let quantity = $("#itemQuantity").val();

				$("#amountID").val(
					amount * quantity
				);
			}
		});
	</script>
<?php endbuild()?>
<?php occupy()?>