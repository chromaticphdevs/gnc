
<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Search Again'))?>
            <div class="card-body">
				<a href="/users/searchUser_qualification">Search Again</a>
				<?php $baseUserDetail = $baseUser['detail']?>
				<h1> <?php echo $baseUserDetail->firstname . ' ' .$baseUserDetail->lastname?> </h1>
				<table class="table">
					<tr>
						<td><h2>ID:</h2></td>
						<td>
							<?php if($baseUser['id']->total_valid_id > 0):?>
								<h2><span class="label label-success"> ID Verified</span></h2>
							<?php else:?>
								<h2><span class="label label-danger">No Verified ID</span></h2>
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<td><h2>Facebook Link</h2></td>
						<td>
							<?php if(!empty($baseUser['fb'])):?>
					
								<?php if($baseUser['fb']->status == "verified"):?>
									<h2><span class="label label-success"> Verified</span></h2>
								<?php elseif($baseUser['fb']->status == "unverified"):?>
									<h2><span class="label label-info"> Verification Pending</span></h2>	
								<?php else:?>
									<h2><span class="label label-danger">Deny</span></h2>
								<?php endif;?>
								
							<?php else:?>
								<h2><span class="label label-danger">No Link</span></h2>
							<?php endif;?>
						</td>
					</tr>

					<tr>
						<td><h2>Messenger Link</h2></td>
						<td>
							<?php if(!empty($baseUser['messenger'])):?>
				
								<?php if($baseUser['messenger']->status == "verified"):?>
									<h2><span class="label label-success"> Verified</span></h2>
									<a class="btn btn-info btn-sm" target="_blank" href="<?php echo $baseUser['messenger']->link?>"><b>View Link</b></a>
								<?php elseif($baseUser['messenger']->status =="unverified"):?>
									<h2><span class="label label-info"> Verification Pending</span></h2>	
								<?php else:?>
									<h2><span class="label label-danger">Deny</span></h2>
								<?php endif;?>

							<?php else:?>
								<h2><span class="label label-danger">No Link</span></h2>
							<?php endif;?>
						</td>
					</tr>



					<tr>
						<td><h2>Total Direct Sponsors:</h2></td>
						<td>
							<?php if($baseUser['directSponsors'] >= 2):?>
								<h2><span class="label label-success"> <?php echo $baseUser['directSponsors']; ?></span></h2>
							<?php else:?>
								<h2><span class="label label-danger"><?php echo $baseUser['directSponsors']; ?></span></h2>
							<?php endif;?>
						</td>
					</tr>


					<tr>
						<td><h2>Product Loan</h2></td>
						<td>	
							<?php if(!empty($baseUser['loan_data'])):?>

								<?php $loan_checker = 0?>
								<?php foreach ($baseUser['loan_data'] as $key => $value):?>

									<?php if($value->status == "Approved" ):?>
									<?php $loan_checker++;?>
									<?php endif;?>

								<?php endforeach;?>

								<?php if($loan_checker>0):?>
										<h2><span class="label label-danger">Has Active Product Loan</span></h2>
								<?php else:?>
										<h2><span class="label label-success">All Loans Paid</span></h2>
								<?php endif;?>

							<?php else:?>
								<h2><span class="label label-success">No Loan</span></h2>
							<?php endif;?>
						</td>
					</tr>

					<tr>
						<td><h2>Cash Loan</h2></td>
						<td>	
							<?php if(!empty($baseUser['cash_loan'])):?>

								<?php $loan_checker = 0?>
								<?php foreach ($baseUser['cash_loan'] as $key => $value):?>

									<?php if($value->status == "Approved" ):?>
									<?php $loan_checker++;?>
									<?php endif;?>

								<?php endforeach;?>

								<?php if($loan_checker>0):?>
										<h2><span class="label label-danger">Has Active Cash Loan</span></h2>
								<?php else:?>
										<h2><span class="label label-success">All Loans Paid</span></h2>
								<?php endif;?>

							<?php else:?>
								<h2><span class="label label-success">No Loan</span></h2>
							<?php endif;?>
						</td>
					</tr>

				</table>
			</div>
		</div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy()?>