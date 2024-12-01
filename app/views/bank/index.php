<?php build('content')?>
<h3>Pera-e Connected</h3>
<table class="table">
	<tr>
		<td>Account Number</td>
		<td><?php echo strObscure($pera->account_number , 5)?></td>
	</tr>
	<tr>
		<td>Linked On</td>
		<td><?php echo $pera->created_at?></td>
	</tr>
	<tr>
		<td>
			<a href="/bank/edit">Edit</a>
		</td>
	</tr>
</table>
<?php endbuild()?>

<?php occupy('templates/layout')?>