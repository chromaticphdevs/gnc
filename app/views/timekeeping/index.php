<?php build('content') ?>
	<h4>Timekeeping</h4>	
	<?php Flash::show()?>

	<?php if(isEqual($auth['type'] , 'auditor')) :?>
		<h4>Auditor has no access on tkapp clock in and out, auditor 
		can only manage the timesheets </h4>
	<?php endif;?>

	<?php if($hasAccount && !isEqual($auth['type'] , 'auditor')) :?>
		<form method="post" action="/timekeeping/login/<?php echo $userToken?>">
			<?php
				Form::hidden('userToken' , $userToken);
			?>
			<div class="form-group">
				<input type="submit" name="" value="Login To Timekeeping" class="btn btn-primary btn-sm">
			</div>
		</form>
	<?php endif;?>

	<?php if( !isEqual($auth['type'] , 'auditor') && !$hasAccount) :?>
		<h4>Ask the auditor to register you account. to have access on timekeeping app</h4>
	<?php endif?>
<?php endbuild()?>
<?php occupy('templates/layout')?>