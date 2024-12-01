<?php build('content') ?>
<div class="col-md-5">
	<div class="card">
		<div class="card-header">
			<h3>Payout Request</h3>
			<a href="/PayoutRequest"> Payouts </a>
		</div>

		<div class="card-body">
			<?php
				Form::open([
					'method' => 'post',
					'action' => '/PayoutBankTransfer/transfer_money'
				]);

				Form::hidden('user_id' , $payout->userId);
				Form::hidden('id' , $payout->id);
				Form::hidden('amount' , $payout->amount);
				Form::hidden('pera_id' , $pera->id ?? 0)
			?>
			<table class="table">
				<tr>
					<td>Username</td>
					<td><?php echo $payout->user->username?></td>
				</tr>

				<tr>
					<td>Name</td>
					<td><?php echo $payout->user->fullname?></td>
				</tr>
				<tr>
					<td>Request Amount</td>
					<td><?php echo to_number($payout->amount)?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><?php echo $payout->status?></td>
				</tr>

				<tr>
					<td>Pera-E Account</td>
					<td><?php echo $pera->account_number ?? 'Invalid'?></td>
				</tr>
				<tr>
					<td>
						<?php if($pera) :?>
							<?php if(isEqual($payout->status , 'pending')) :?>
								<input type="submit" name="" 
								value="Transfer To Pera-E" 
								class="btn btn-primary btn-sm">
							<?php endif;?>
						<?php else:?>
							<p>User must connect pera-e 
								send the below link to user to create 
								<strong>Pera-e</strong> account <br/>

								<strong>
									<label>http://dev.pera/registration</label>
								</strong>
							</p>
							<a href="#"></a>
						<?php endif;?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>