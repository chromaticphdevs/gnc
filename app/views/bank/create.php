<?php build('content')?>

<div class="container">
<h4>Connect to : Pera-E</h4>
	<?php Flash::show()?>
	<?php
		Form::open([
			'method' => 'post',
			'action' => '/Bank/register'
		]);
	?>

	<div class="form-group">
		<?php
			Form::label('Key');
			Form::text('apiKey' , '' , [
				'class' => 'form-control',
				'required' => ''
			]);
		?>
	</div>

	<div class="form-group">
		<?php
			Form::label('Secret');
			Form::text('apiSecret' , '' , [
				'class' => 'form-control',
				'required' => ''
			]);
		?>
	</div>

	<?php
		Form::submit('', 'Connect' , [
			'class' => 'btn btn-primary btn-sm'
		]);
	?>

	<div>
		<a href="https://pera-e.com/" target="_blank">Dont have an account ? Create your <span>free account on pera-e</span></a>
	</div>
	<?php Form::close()?>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>