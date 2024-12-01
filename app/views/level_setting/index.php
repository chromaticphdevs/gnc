<?php build('content')?>
	<h3>Level Settings</h3>

	<div class="well">
		<div class="alert alert-info">
			To Change to amount simply change the amount value and press "ENTER"
		</div>
		<table class="table">
			<thead>
				<th>Level</th>
				<th>Amount</th>
				<th>Hierarchy</th>
			</thead>

			<tbody>
				<?php foreach($levels as $key => $row) :?>
					<tr>
						<td>
							<span class="badge badge-info"><?php echo $row->level?></span>
						</td>
						<td>
							<input type="text" name="" value="<?php echo $row->amount?>"
							class='amount' data-id="<?php echo $row->id?>">
						</td>
						<td><?php echo $row->hierarchy?></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
	</div>
<?php endbuild()?>


<?php build('scripts') ?>
<script type="text/javascript" defer>
	$(document).ready(function() {
		let url = get_url('API_LevelSettting/update');

		$('.amount').change( function() 
		{
			let id = $(this).attr('data-id');
			let amount = $(this).val();

			if(isNaN(amount))
				return alert("Invalid Amount");
			
			$.post(url , {amount: amount , id : id} , function(response) {
				console.log(response);
			}).done(function(data) {
				alert("Amount Updated");
			});
			
		});
	});
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>