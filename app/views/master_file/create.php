<?php build('content')?>
<div class="col-md-8">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Master File</h4>
			<a href="/AccountProfile">Back To Profile</a>
			
		</div>

		<div class="card-body">
			<?php Flash::show()?>
			<?php
				Form::open([
					'method' => 'post',
					'action' => ''
				]);

				Form::hidden('user_id', $user->id);
			?>
				<h4>Personal</h4>
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<?php
								Form::label('First Name *');  
								Form::text('firstname', $post['firstname'] ?? $user->firstname , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Middle Name *');  
								Form::text('middlename', $post['middlename'] ?? $user->middlename , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Last Name *');  
								Form::text('lastname', $post['lastname'] ?? $user->lastname , [
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
								Form::label('Birth date *');  
								Form::date('date_of_birth', $post['date_of_birth'] ?? '' , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Birth Place *');  
								Form::text('place_of_birth', $post['place_of_birth'] ?? '' , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>

						<div class="col-md-2">
							<?php
								Form::label('Gender *');  
								Form::select('gender',['male','female'] , $post['gender'] ?? '' , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>

						<div class="col-md-2">
							<?php
								Form::label('Nationality *');  
								Form::text('nationality', $post['nationality'] ?? '' , [
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
								Form::label('Occupation *');  
								Form::text('occupation', $post['occupation'] ?? '', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Weight');  
								Form::text('weight', $post['weight'] ?? '' , [
									'class' => 'form-control'
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Height');  
								Form::text('height', $post['height'] ?? '' , [
									'class' => 'form-control'
								])
							?>
						</div>
					</div>
				</div>
				<h4>Contact & Address</h4>
				<div class=" form-group">
					<div class="row">
						<div class="col-md-6">
							<?php
								Form::label('Email *');  
								Form::text('email', $post['email'] ?? $user->email , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-6">
							<?php
								Form::label('Phone *');  
								Form::text('phone', $post['phone'] ?? $user->mobile , [
									'class' => 'form-control'
								])
							?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<?php
								Form::label('Address *');  
								Form::textarea('address', $post['address'] ?? $user->address , [
									'class' => 'form-control',
									'required' => true,
									'rows' => 2
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('City/Province *');  
								Form::text('city', $post['city'] ?? '' , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col-md-4">
							<?php
								Form::label('Country Code');  
								Form::text('country_code', $post['country_code'] ?? '' , [
									'class' => 'form-control'
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