<?php build('content') ?>
<div class="col-md-8">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Add Beneficiaries</h4>
			<a href="/AccountProfile">Back To Profile</a>
			<?php Flash::show()?>
		</div>

		<div class="card-body">
			<?php
				Form::open([
					'method' => 'post'
				]);

				Form::hidden('user_id', $user->id);
			?>
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<?php
								Form::label('First Name *');
								Form::text('firstname','', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>

						<div class="col-md-4">
							<?php
								Form::label('Middle Name *');
								Form::text('middlename','', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>

						<div class="col-md-4">
							<?php
								Form::label('Last Name *');
								Form::text('lastname','', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<?php
								Form::label('Gender *');
								Form::select('gender',['male','female'],'', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>

						<div class="col-md-4">
							<?php
								Form::label('Date of Birth *');
								Form::date('date_of_birth','', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<?php
								Form::label('Email*');
								Form::text('email','', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Mobile Number *');
								Form::text('mobile','', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<?php Form::submit('', 'Save', ['class' => 'btn btn-primary'])?>
				</div>

			<?php Form::close()?>
		</div>
	</div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>