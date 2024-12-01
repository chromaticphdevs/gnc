<?php build('content') ?>
<?php if($personal) :?>
<div class="text-center">
	<h2>Master List</h2>
	<label class="badge bg-primary">For Approval</label>	
</div>


<div class="row">
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Personal Information</h4>
			</div>

			<div class="card-body">
				<section>
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Name</td>
								<td><?php echo "{$personal->lastname}, {$personal->firstname} {$personal->middlename}"?></td>
							</tr>

							<tr>
								<td>Contact</td>
								<td><?php echo $personal->phone?> / <?php echo $personal->email?></td>
							</tr>

							<tr>
								<td>Nationality</td>
								<td><?php echo $personal->nationality?></td>
							</tr>
							<tr>
								<td>Height & Weight</td>
								<td>(H) <?php echo $personal->height?> (W) <?php echo $personal->weight?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $personal->gender?></td>
							</tr>

							<tr>
								<td>Birhtdate</td>
								<td><?php echo $personal->date_of_birth?> / <?php echo $personal->place_of_birth?></td>
							</tr>

							<tr>
								<td>Occupation</td>
								<td><?php echo $personal->occupation?></td>
							</tr>

							<tr>
								<td>Address</td>
								<td><?php echo $personal->address?></td>
							</tr>

							<tr>
								<td>City/Province</td>
								<td><?php echo "{$personal->city} {$personal->country_code}"?></td>
							</tr>
						</table>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4 class="card-title">Beneficiaries</h4>
		<a href="/MasterFileController/beneficiaryCreate" class="btn btn-primary">Add Beneficiary</a>
	</div>

	<div class="card-body">
		<section>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<th>Name</th>
						<th>Gender</th>
						<th>Birth date</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Is Approved</th>
					</thead>

					<tbody>
						<?php foreach($personal->beneficiaries as $beneficiaryKey => $beneficiaryValue) :?>
							<tr>
								<td><?php echo "{$beneficiaryValue->lastname}, {$beneficiaryValue->firstname} {$beneficiaryValue->middlename}"?></td>
								<td><?php echo $beneficiaryValue->gender?></td>
								<td><?php echo $beneficiaryValue->date_of_birth?></td>
								<td><?php echo $beneficiaryValue->phone?></td>
								<td><?php echo $beneficiaryValue->email?></td>
								<td>On-going</td>
							</tr>
						<?php endforeach?>
					</tbody>
					<tr>
				</table>
			</div>
		</section>
	</div>
</div>	

<?php else:?>
	<div class="card text-center">
		<div class="card-header">
			<h4 class="card-title">There are no info on your master list</h4>
		</div>
		<div class="card-body">
			<div class="alert alert-primary">
				<a href="/MasterFileController/create" class="btn btn-primary btn-lg">Start</a>
			</div>
		</div>
	</div>
<?php endif?>
<?php endbuild()?>
<?php occupy()?>