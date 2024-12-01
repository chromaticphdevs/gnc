<?php build('content') ?>
	<?php $baseUserDetail = $baseUser['detail']?>
	<?php $upline = $baseUser['upline']?>
	<?php $directSponsor = $baseUser['directSponsor']?>
	<div class="card">
		<?php echo wCardHeader(wCardTitle($baseUserDetail->firstname . ' ' .$baseUserDetail->lastname)) ?>
		<div class="card-body">
			<a href="/Account/searchUser">Search Again</a>
			<div class="col-md-6 mx-auto">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>Username</td>
							<td><?php echo $baseUserDetail->username?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $baseUserDetail->email?></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>
								<input type="text" name="mobile_number" value="<?php echo $baseUserDetail->mobile?>"
									data-id="<?php echo $baseUserDetail->id?>">
								<br> <a href="#" id="change_phone_number">Click Here to apply changes</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<table class="table">
		

		<tr>
			<td>Direct Sponsor : </td>
			<?php if($directSponsor) :?>
			<td>
				<?php echo $directSponsor->fullname?> <strong>(<?php echo $directSponsor->username?>)</strong>
				<a href="/AccountProfile/?userid=<?php echo $directSponsor->id?>" target="_blank">View Profile</a>
			</td>
			<?php else:?>
				<td>No Direct Sponsor Found.</td>
			<?php endif;?>
		</tr>

		<tr>
			<td>Upline: </td>
			<?php if($upline) :?>
			<td>
				<?php echo $upline->fullname?> <strong>(<?php echo $upline->username?>)</strong>
				<a href="/AccountProfile/?userid=<?php echo $upline->id?>" target="_blank">View Profile</a>
			</td>
			<?php else:?>
				<td>No Upline Found.</td>
			<?php endif;?>
		</tr>
		<tr>
			<td>Sales Chart Position</td>
			<td><?php echo $directSponsor->L_R ?? 'Not Available'?></td>
		</tr>

		<tr>
			<td>Manually Change Sponsor And Upline</td>
			<td><a href="/Account/updateHigherUser?userid=<?php echo $baseUserDetail->id?>">Go to Page</a></td>
		</tr>
		<tr>
			<td><a target="_blank" href="/UserIdVerification/get_user_uploaded_id/<?php echo $baseUserDetail->id?>">View All ID uploaded</a></td>
			
		</tr>

		<?php if(isset($data['baseUser']['social'])):?>

			<?php foreach($data['baseUser']['social'] as $social_links) :?>
				<?php if($social_links->type == "Facebook" and $social_links->type = "verified"):?>
				<tr>
					<td><a target="_blank" href="<?php echo $social_links->link ?>">View Social Media</a></td>
					<td>
						 <a class="btn btn-danger btn-sm" href="/UserSocialMedia/change_status_admin/?status=deny&id=<?php echo $data['baseUser']['social']->id?>&comment=admin deny">Unverify</a>
					</td>
				</tr>
				<?php elseif($social_links->type = "Messenger" and $social_links->type = "verified"):?>
				<tr>
					<td>Messenger Link</td>
					<td>
						<a class="btn btn-info btn-sm" target="_blank" href="<?php echo $social_links->link ?>">View Messenger</a>
					</td>
				</tr>
				<?php endif; ?>
			<?php endforeach;?>
		<?php endif; ?>

		<tr>
			<td><a href="#" class='toggle' data-target=".password-container">Change Password</a></td>
		</tr>

		<?php $loan_checker = 0?>
	    <?php foreach($data['baseUser']['loan_data'] as $check) :?>
	          <?php if($check->status == "Approved" ):?>
	            <?php $loan_checker++;?>
	          <?php endif;?>
        <?php endforeach;?>

		<?php if(!empty($data['baseUser']['toc_details']) && $loan_checker == 0): ?>
		<tr>
			<td><h4>Position: &nbsp;&nbsp; <b style="color:green" onclick="input_text()"><?php echo $data['baseUser']['toc_details']->position ?></b>
			<br>Status:  &nbsp;&nbsp; <b style="color:green">

				<?php if($data['baseUser']['toc_details']->is_standby == 1): ?>
					<?php echo "On Standby" ?> &nbsp;&nbsp;
					<a class="btn btn-success btn-sm" href="/TocController/remove_to_standby/<?php echo seal($data['baseUser']['toc_details']->userid) ?>">Remove to standby</a></td>
				<?php else: ?>
					<?php echo "Ready" ?> &nbsp;&nbsp;
					<a class="btn btn-danger btn-sm" href="/TocController/move_to_standby/<?php echo seal($data['baseUser']['toc_details']->userid) ?>" id="move_to_standby">Move to standby</a></td>
				<?php endif; ?>

			</b></h4></td>
			<td>
				 <form  action="/TocController/change_position" method="post">
		
					<div id="myDIV">
						<input type="number" name="position" id="toc_position" required>
						<input type="hidden" name="userId" value="<?php echo seal($data['baseUser']['toc_details']->userid) ?>" >
					</div> 
					 <input type="submit" class="btn btn-primary btn-sm validate-action" value="Change Position" id="change_position">

				</form>
		</tr>
		<?php else: ?>
				<h4><b style="color:red">No Position or Unpaid Loan</b></h4>
	    <?php endif; ?>

	</table>



	<div class="well password-container" style="display: none">
		<div>
			<h4>Change Password</h4>
		</div>

		<?php
			Form::open([
				'method' => 'post',
				'action' => '/account/changePassword'
			]);

			Form::hidden('userid' , $baseUserDetail->id);

			Form::hidden('redirectTo' , 'Account/doSearch/?username='.$baseUserDetail->username.'&searchOption=username');
		?>

		<div class="form-group">
			<?php
				Form::password('password' , '' , [
					'class' => 'form-control'
				]);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::submit('changePassword' , 'Update Password' , [
					'class' => 'btn btn-primary'
				]);
			?>
		</div>
		<?php Form::close();?>
	</div>


	<?php if(!$upline || !$directSponsor) :?>
	<div class="well">
		<h4>Rollback Upline and Direct Sponsor</h4>
		<table class="table">
			<!-- ROLLBACK USER TO PREVIOUS UPLINE AND DIRECT SPONSOR-->
			<?php if(isset($previous)) :?>
				<?php if($previous['upline'] != false) :?>
					<tr>
						<td>Upline</td>
						<td>
							<?php echo $previous['upline']->firstname . ' '.$previous['upline']->lastname?>
							<strong>(<?php echo $previous['upline']->username?>)</strong>
						</td>
					</tr>
				<?php endif;?>

				<?php if($previous['directSponsor']) :?>
					<tr>
						<td>Direct Sponsor</td>
						<td>
							<?php echo $previous['directSponsor']->firstname . ' '.$previous['directSponsor']->lastname?>
							<strong>(<?php echo $previous['directSponsor']->username?>)</strong>
						</td>
					</tr>
				<?php endif;?>

				<tr>
					<td>Password</td>
					<td><span class="baege badge-warning">123456</span></td>
				</tr>
			<?php endif;?>
		</table>
		<?php
			Form::open([
				'method' => 'post',
				'action' => '/AccountRollback/rollback'
			]);

			Form::hidden('userid' , $baseUserDetail->id);
			Form::hidden('upline' , $previous['upline']->id ?? 0);
			Form::hidden('directSponsor' , $previous['directSponsor']->id ?? 0);
		?>

		<div class="form-group">
			<input type="submit" name="" value="Roll back" 
				class="btn btn-primary btn-sm form-confirm">
		</div>
		<?php Form::close()?>
	</div>
	<?php endif;?>
	<!---  --------------------------------------------cash advance--------------------------------------------------------->

	    <br>
	    <h2><b>Cash Advance</b></h2>
	    <table class="table">
		        <thead>
		            <th>#</th>
		            <th>Loan Number</th>
		            <th>Date & Time</th>   
		            <th>Amount</th>
		            <th>Payment</th>
		            <th>Balance</th>
		            <th>Status</th>
		        </thead>

		         <tbody>
		               <?php $counter = 1;?>
		               <?php foreach ($data['baseUser']['cash_loan'] as $key => $value):?>
		                  <tr>
		                        <td><?php echo $counter ?></td>
		                        <td>#<?php echo $value->code; ?></td>
		                        <td>
		                        <?php
		                            $date=date_create($value->created_on);
		                            echo date_format($date,"M d, Y");
		                            $time=date_create($value->created_on);
		                            echo date_format($time," h:i A");
		                          ?>
		                        </td>   
		                        <td><?php echo $value->amount; ?></td>
		                        <td><?php echo $value->payment; ?></td>
		                        <td><?php echo ($value->amount) - $value->payment; ?></td>

		                        <td style="text-align: center;">
		                              <?php if($value->status != "Paid" ):?>
		                                 <h4><b><span class="label label-info">NOT PAID</span></b></h4>
		                              <?php else:?>
		                                 <h4><b><span class="label label-success">PAID</span></b></h4>
		                              <?php endif;?>
		                        </td>
		                  </tr>
		                <?php $counter++;?>
		                <?php endforeach;?>
		        </tbody>
		    </table>
		<br>
	<div style="overflow-x:auto;">
	<h2><b>Product Advance</b></h2>
    <table class="table">
	        <thead>
	            <th>#</th>
	            <th>Loan Number</th>
	            <th>Loan Created</th>   
	            <th>Full Payment</th>
	            <th>Full Name</th>
	            <th>Amount</th>
	            <th>Delivery Fee</th>
	            <th>Payment</th>
	            <th>Balance</th>
	            <th>Package</th>
	            <th>Status</th>
	         
	        </thead>

	         <tbody>

	               <?php $counter = 1;?>
	               <?php foreach($data['baseUser']['loan_data'] as $data) :?>
	                  <tr>
	                        <td><?php echo $counter ?></td>
	                        <td>#<?php echo $data->code; ?></td>
	                        <td>
	                        <?php
	                            $date=date_create($data->date_time);
	                            echo date_format($date,"M d, Y");
	                           // $time=date_create($data->date_time);
	                           // echo date_format($time," h:i A");
	                          ?>
	                        </td>   
	                       <td>
	                        <?php
	                  		 	 if($data->status == "Paid" )
	                  		 	 {
		                            $date=date_create($data->updated_at);
		                            echo date_format($date,"M d, Y");
		                           // $time=date_create($data->updated_at);
		                           // echo date_format($time," h:i A");
	                      		  }
	                          ?>
	                        </td>   
	                        <td><?php echo $data->fullname; ?></td>
	                        <td><?php echo $data->amount; ?></td>
	                        <td><?php echo $data->delivery_fee; ?></td>
	                        <td><?php echo $data->payment; ?></td>
	                        <td><?php echo ($data->amount + $data->delivery_fee ?? 0) - $data->payment; ?></td>
	                        <td><?php echo $data->package; ?></td>
	                        <td style="text-align: center;">
	                              <?php if($data->status == "Approved" ):?>
	                                 <h4><b><span class="label label-info">NOT PAID</span></b></h4>
	                              <?php elseif($data->status == "Return" ):?>
	                                 <h4><b><span class="label label-warning">Returned</span></b></h4>
	                              <?php else:?>
	                                 <h4><b><span class="label label-success">PAID</span></b></h4>
	                              <?php endif;?>
	                        </td>
	                 
	                  </tr>
	                <?php $counter++;?>
	                <?php endforeach;?>
	        </tbody>
	    </table>
	    

	</div>
<?php endbuild()?>

<?php build('scripts')?>
	<script type="text/javascript">
		$( document ).ready( function (evt) {

			$("#change_phone_number").click( function(evt) {

				let mobileAndUser = $("input[name='mobile_number']");

				let mobileNumber = mobileAndUser.val();
				let userId   = mobileAndUser.attr('data-id');

				let url = get_url('API_User/updateMobile');

				$.ajax( {

					method: 'post',
					url : url,
					data: {
						mobileNumber : mobileNumber,
						userId : userId
					},

					success : function(response) 
					{
						response = JSON.parse(response);

						let responseData = response.data;

						alert(responseData);
					}
				});
			});
		});


      $("#move_to_standby").on('click' , function(e)
      {
         if (confirm("Move to Standby?"))
         {
            return true;
         }else
         {
           return false;
         }
      });

      $("#change_position").on('click' , function(e)
      {
         if (confirm("Change Position?"))
         {
            return true;
         }else
         {
           return false;
         }
      });

      var x = document.getElementById("myDIV");
	  x.style.display = "none";
	  function input_text() 
	  {	
	  	  document.getElementById("toc_position").value = "";
		  var x = document.getElementById("myDIV");

		  if (x.style.display === "none") 
		  {
			    x.style.display = "block";
		  } else 
		  {
			    x.style.display = "none";
		  }
	  }

	</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>