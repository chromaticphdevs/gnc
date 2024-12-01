<?php build('content') ?>
	
	<h4>Register <strong><?php echo $fnaccount->name?></strong> to Timekeeping App.</h4>
	<?php Flash::show()?>
	<div>
		<a href="/timekeeping/getUsers?user_status=without_accounts">Return To List</a>
	</div>
	<div class="col-md-6 mx-auto">
		<?php
			$accountName = explode(' ' , $fnaccount->name);
		?>
		<?php
			Form::open([
				'method' => 'post',
				'action' => '/Timekeeping/submitRegistration'
			]);
			
			Form::hidden('userToken' , $userToken);
			Form::hidden('user_id' , $fnaccount->id);
			Form::hidden('domain' , '1');
			Form::hidden('username' , $fnaccount->username);
		?>

		<div class="form-group">
			<?php
				Form::label('First Name');
				Form::text('firstname' , $accountName[0] , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Last Name');
				Form::text('lastname' , $accountName[1] ?? '', [
					'class' => 'form-control',
				])
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Rate Per Day');
				Form::text('ratePerDay' , '' , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Work Hours');
				Form::text('workHours' , '' , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Maximum Work Hours');
				Form::text('maxWorkHours' , '' , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>

		<div class="form-group">
			<?php Form::submit('' , 'Register Account')?>
		</div>
		<?php Form::close()?>

	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>