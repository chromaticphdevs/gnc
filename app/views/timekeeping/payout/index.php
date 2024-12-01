<?php build('content') ?>
	<h4>Timekeeping Payout</h4>	
	<?php Flash::show()?>

	<?php
		Form::open([
			'method' => 'POST',
			'action' => '/TKPayout/multiplePayout'
		]);

		Form::hidden('token' , $tkAppSession);
	?>

	<input type="button" id="check_button"  value="Check All" />
	<input type="button" id="uncheck_button"  value="Uncheck All" />


	<div class="table-responsive">
		<table class="table">
			<thead>
				<th>#</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Username</th>
				<th>Amount</th>
				<th>Pera-E Account</th>
				<th>Payout</th>
			</thead>

			<tbody>
				<?php foreach($wallets as $key => $wallet) :?>
					<?php if($wallet->wallet_total <= 0) continue ?>
					<tr>
						<td>
							<input type="checkbox" class="my_check_box"  name="usersId[]"
								value="<?php echo $wallet->user_id?>" >
						</td>
						<td><?php echo $wallet->firstname?></td>
						<td><?php echo $wallet->lastname?></td>
						<td><?php echo $wallet->username?></td>
						<td><?php echo $wallet->wallet_total?></td>
						<td>
							<?php if(!$wallet->pera):?>
								No Pera Account
							<?php else:?>
								<?php echo $wallet->pera->account_number?>
							<?Php endif?>
						</td>
						<td>
							<a href="/TKPayout/singlePayout/<?php echo $tkAppSession .'?user_id='.seal($wallet->user_id)?>">Payout</a>
						</td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
	</div>
	<?php
		Form::submit('' , 'Release Payout' , [
			'class' => 'btn btn-primary btn-sm'
		]);
	?>
	<?php Form::close()?>
<?php endbuild()?>

<?php build('scripts') ?>

	 <script type="text/javascript" defer>
	
		 $( document ).ready(function(){
	
		      $("#check_button").on('click' , function(e)
		      {	
		      
					$('.my_check_box').prop('checked', true);  
			  });


		      $("#uncheck_button").on('click' , function(e)
		      {	
		      
					$('.my_check_box').prop('checked', false);  
			  });
			   
		 });
	</script>
<?php endbuild()?>

<?php occupy('templates/layout')?>