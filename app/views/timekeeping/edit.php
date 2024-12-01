<?php build('content') ?>
	<h4>
		<strong><?php echo $appUserData->firstname . ' ' .$appUserData->lastname?></strong>
		TimkeepingApp Details
	</h4>

	<hr>
	<a href="/timekeeping/getUsers">Return</a>

		<?php
			Form::open([
				'method' => 'post',
				'action' => '/Timekeeping/updateAppData'
			]);

			Form::hidden('userToken' , $appUserData->domain_user_token);
		?>
		<div class="form-group">
			<?php
				Form::label('Rate Per Day');
				Form::text('ratePerDay' , $appUserData->rate_per_day , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>
		<div class="form-group">
			<?php
				Form::label('Work Hours');
				Form::text('workHours' , $appUserData->work_hours , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Maximum Work Hours');
				Form::text('maxWorkHours' , $appUserData->max_work_hours , [
					'class' => 'form-control',
					'required' => ''
				])
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Username');
				Form::text('username', $appUserData->user->username , [
					'class' => 'form-control',
					'readonly' => ''
				]);
			?>
		</div>

		<div class="form-group">
			<?php Form::submit('' , 'Update Account'  , [
				'class' => 'btn btn-primary'
			])?>
		</div>
		<?php Form::close()?>
<?php endbuild()?>
<?php occupy('templates/layout')?>