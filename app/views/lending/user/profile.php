<?php require_once VIEWS.DS.'lending/template/header.php'?>
<style type="text/css">
	table img
	{
		width: 100px;
	}
	.id-picture
	{
		width: 100%;
	}

	.my-users
	{
		padding: 10px;
		margin-bottom: 7px;

		background: #eee;
		color: #000;

		border:2px solid #000;
}
</style>
</head>
<body style="">

	<main class="ui container">
		<div class="ui inverted menu">
		  <a class="item" href="/LDUser/logout">
		    LOGOUT
		  </a>
		  &nbsp;
		   <a class="item">
			 <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
			  <span class="label label-success"><?php  echo Session::get('user')['type'];?></span>
		  </a>

		  	<?php if(Session::get('user')['type']== "super admin"):?>
				   <a class="item" href="/LDProductAdvance/create_activation_code">
						Create Activation Code
				  </a>
				  <a class="item" href="/LDActivation/history_activation_code">
						Activation Code History
				  </a>
					<a class="item" href="/LDDeviceToken/">
					    Device Token (Beta)
					</a>
					<a class="item" href="/LDTransferAccount/">
					    Transfer Account (Beta)
					</a>
			<?php endif; ?>
			
			<?php if(Session::get('user')['type']== "admin" OR Session::get('user')['type']== "cashier"):?>
				   <a class="item" data-toggle="modal" data-target="#myModal">
						Purchase Package
				  </a>
			<?php endif; ?>

			<?php if(Session::get('user')['type']== "customer"):?>
				   <a class="item" href="/LDPayment/make_payment/<?php echo Session::get('user')['id']; ?>">
						Post Payment
				  </a>
			<?php endif; ?>
			<a class="item" href="/LDGeneology/binary">
			    Binary(Beta)
			</a>
		</div>
		
		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">


			<?php if(Session::get('user')['type']=="admin" || Session::get('user')['type']== "super admin"):?>

		          <!--<select name="preview_user" id="preview_user" onchange="preview_user_data()" class="selectpicker" data-live-search="true">
				       	<?php foreach($userList as $user) :?>
				      		<option value="<?php echo $user->userID;?>">
				      	<?php echo $user->NAME;?>
				      		
				      	</option>
				     	<?php endforeach;?>
				 </select>-->

				<input type="text" class="form-control" name="refer_name" id="refer_name" onkeyup="search_data()" >
				<div id="search_data2">
			    </div>

			<?php endif; ?>



				<script>

				
		
					
			    </script>

			<div class="ui segment">
					<h4>Geneology</h4>
				

						 <table class="ui celled table">
							<?php echo  Session::get('user')['firstname'] ?>
							<th>Left</th>
							<th>Right</th>
								<?php foreach($geneology as $data):	?>

									<?php if($data->L_R=="LEFT"):?>
										 <tr>
										     	<td><?php echo $data->dbbi_id.' '.$data->firstname.' '. $data->lastname;?></td>
										       	<td></td>
										 </tr>
									 <?php else: ?>
									 	 <tr>
									     	<td></td>
									       	<td><?php echo $data->dbbi_id.' '.$data->firstname.' '. $data->lastname;?></td>
									 </tr>
									<?php endif; ?>
								 <?php endforeach; ?>
						 </table>
			</div>

	         <!-- CASH and product PAYMENTS today -->
		<?php  $user  = Session::get('user');?>
	         	<!--vault-->
	        <?php if(isset($vaultSummary)) :?>
				<div class="ui segment">
					<h4>Branch Vault</h4>
					<?php if($user['type'] == 'admin'):?>

						<?php if(isset($vaultSummary['branch_vault_balance']->balance)):?>
						
							<div>Balance : <?php echo $vaultSummary['branch_vault_balance']->balance?></div>

						<?php else:?>	
							<div>Balance : 0</div>
						<?php endif;?>	
			

							
						
					<?php elseif($user['type'] == 'super admin'):?>

						 <table class="ui celled table">
							<th>Branch Name</th>
							<th>Balance</th>
							<th>Transfer</th>
								<?php foreach($vaultSummary['branch_vault_balance_all'] as $data):	?>
									 <tr>	
									 
									     	<td><?php echo $data->name;?></td>
									       	<td><?php echo $data->balance; ?></td>
									       	<td><button class="btn btn-success btn-sm" id="transfer_btn" data-id="<?php echo $data->branch_id; ?>">Transfer to Main</button></td>
									 </tr>
								 <?php endforeach; ?>
						 </table>

					<?php endif;?>


				</div>
			<?php endif;?>

			  <?php if(isset($inventorySummary)) :?>
				<div class="ui segment">
					<h4>Branch Inventory</h4>
					<?php if($user['type'] == 'admin'):?>

						 <table class="ui celled table">

							<th>Product Name</th>
							<th>Stock</th>
								<?php foreach($inventorySummary['branch_inventory_stock'] as $data):	?>
									 <tr>
									     	<td><?php echo $data->product_name;?></td>
									       	<td><?php echo $data->stock; ?></td>
									 </tr>
								 <?php endforeach; ?>
						 </table>


					<?php elseif($user['type'] == 'super admin'):?>
						 <table class="ui celled table">

							<th>Branch Name</th>
							<th>Product Number</th>
							<th>Stock</th>
								<?php foreach($inventorySummary['branch_inventory_stock_all'] as $data):	?>
									 <tr>
									     	<td><?php echo $data->branch_name;?></td>
									     	<td><?php echo $data->product_name;?></td>
									       	<td><?php echo $data->stock; ?></td>
									 </tr>
								 <?php endforeach; ?>
						 </table>

					<?php endif;?>
				</div>
			<?php endif;?>



				<!--- ATTENDANCE   --->
			<?php if(isset($attendanceSummary)) :?>
				<div class="ui segment">
					<h4>Attendance Summary</h4>
					<div>First Timers : <?php echo $attendanceSummary['firstimerTotal']?></div>
					<div>Repeat : <?php echo $attendanceSummary['repeatTotal']?></div>
					<div>Total : <?php echo $attendanceSummary['firstimerTotal'] + $attendanceSummary['repeatTotal']?>
					release
					</div>
				</div>
			<?php endif;?>


		
			<?php if(isset($loanToday)) : ?>

			<div class="ui segment">

				<h4>Collections Summary</h4>

				<?php if($user['type'] == 'admin'): ?>
				<div>Cash : <?php echo $loanToday['cashLoanTotal']?></div>
				<div>Product : <?php echo $loanToday['productLoanTotal']?></div>
				<div>Interest : <?php echo $loanToday['interestTotal']?></div>
				<?php $total_today_collections=$loanToday['cashLoanTotal']+$loanToday['interestTotal']+$loanToday['productLoanTotal'];?>
				<div>Total : <?php echo $total_today_collections; ?></div>
			
				<?php elseif($user['type'] == 'super admin'):?>
					
				<table class="ui celled table">
					<th>Branch</th>
					<th>Collections</th>
					<th>Total</th>
					<?php foreach($loanToday['collection_summary_by_branch'] as $data):	?>
					<tr>
						<td><?php echo $data->branch_name?></td>
						<td>
								 <table class="ui celled table">
								 	<th>Cash</th>
									<th>Product</th>
									<th>Interest</th>
						            <tr>
						            	<td><?php echo $data->cash_payment_total?></td>
						            	<td><?php echo $data->product_payment_total?></td>
						            	<td><?php echo $data->cash_interest_total?></td>
						            </tr>
						         </table>
							
						</td>
						<?php $total=$data->cash_payment_total+$data->product_payment_total+$data->cash_interest_total?>
						<td><?php echo $total;?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif;?>
			</div>

			<?php endif;?>

			<?php if(isset($loanToday)) :?>
				<!--cash-->
				<div class="ui segment">
					<h4>Cash Payments Today</h4>
					<table  id="table-data" class="ui celled table">
						<thead>
							<th>Img</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>Note</th>
							<th>Status & Date</th>
						</thead>
						<tbody>
							<?php foreach($loanToday['cash_paymentToday'] as $cash_paymentToday) :?>
								<?php
									$interest = ($cash_paymentToday->balance*0.05)/4;
									$principal= $cash_paymentToday->balance/25;
									$total    = $interest+$cash_paymentToday->balance/25;
								?>
								
								<tr>
									<td  width="40" height="80"><img style="max-height:100%; max-width:100%" src="<?php echo URL.DS.'assets/'.$cash_paymentToday->faceimage?>" ></td>
									<td><?php echo $principal?></td>
									<td><?php echo $interest?></td>
									<td>
										<?php 
											echo $cash_paymentToday->note;
										?>
									</td>
									<td>
										<?php if($cash_paymentToday->is_approved == 0) :?>
											<span class="label label-info">Pending</span>
										<?php else :?>
											<span class="label label-success">Approved</span>
										<?php endif;?>
										<?php 
										    echo "<br><br>";
											echo date_long($cash_paymentToday->created_on);
											echo "<br>";
											echo time_long($cash_paymentToday->created_on);
										?>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div><!--cash end-->

				<!--product-->
				<div class="ui segment">
					<h4>Product Payments Today</h4>
					<table id="table-data2"  class="ui celled table">
						<thead>
							<th>Img</th>
							<th>Amount</th>
							<th>Balance</th>
							<th>Note</th>
							<th>Status & Date</th>
						</thead>
						<tbody>
							<?php foreach($loanToday['product_paymentToday'] as $product_paymentToday) :?>
								<tr>
									<td  width="40" height="80"><img style="max-height:100%; max-width:100%"  src="<?php echo URL.DS.'assets/'.$product_paymentToday->faceimage?>"></td>
									<td><?php echo $product_paymentToday->amount; ?></td>
									<td><?php echo $product_paymentToday->balance; ?></td>
									<td>
										<?php 
											echo $product_paymentToday->note;
										?>
									</td>
									<td>
										<?php if($product_paymentToday->is_approved == 0) :?>
											<span class="label label-info">Pending</span>
										<?php else :?>
											<span class="label label-success">Approved</span>
										<?php endif;?>
										<?php 
											echo "<br><br>";
											echo date_long($product_paymentToday->created_on);
											echo "<br>";
											echo time_long($product_paymentToday->created_on);
										?>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>	<!--product end-->	
				<?php endif;?>
			   <!-- //CASH and Product PAYMENTS today-->

				<!-- MARK ANGELO GONZALES DISPLAY ALL TOTAL LOAN 
				<?php if(isset($loanToday)) :?>
					<section>
						<div>
							Total Loan as of : <?php echo date('M-d-Y')?> &nbsp;
							<h4 style="display: inline-block;">Cash : <?php echo $loanToday['cash']?></h3>
							<h4 style="display: inline-block;">Product : <?php echo $loanToday['product']?></h3>
						</div>
						
						<section>
							<div class="ui segment">
								<h3>Cash Loan</h3>
								<table class="table">
									<thead>
										<th>Name</th>
										<th>Status</th>
										<th>Amount</th>
										<th>Action</th>
									</thead>
									<tbody>
										<?php $totalReleased = 0;?>
										<?php foreach($loanToday['cashLoanListToday'] as $cashLoan) : ?>
											<?php 
												if($cashLoan->status == 'Approved')
												{
													$totalReleased += $cashLoan->amount;
												}
											?>
											<tr>
												<td><?php echo $cashLoan->borrower_name?></td>
												<td><?php echo $cashLoan->status?></td>
												<td><?php echo $cashLoan->amount?></td>
												<td>
													<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

			       									<a  class="btn btn-danger btn-sm" href="/LDProductAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">Disapprove</a>
												</td>
											</tr>
										<?php endforeach;?>
									</tbody>
								</table>

								<div><h4>Released: <?php echo $totalReleased?></h4></div>
							</div>
							<hr>
							<div class="ui segment">
								<h3>Product Loan</h3>
								<table class="table">
									<thead>
										<th>Name</th>
										<th>Status</th>
										<th>Amount</th>
										<th>Action</th>
									</thead>
									<tbody>
										<?php $totalReleased = 0;?>
										<?php foreach($loanToday['productLoanListToday'] as $cashLoan) : ?>
											<?php 
												if($cashLoan->status == 'Approved')
												{
													$totalReleased += $cashLoan->amount;
												}
											?>
											<tr>
												<td><?php echo $cashLoan->borrower_name?></td>
												<td><?php echo $cashLoan->status?></td>
												<td><?php echo $cashLoan->amount?></td>
												<td>
													<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

			       									<a  class="btn btn-danger btn-sm" href="/LDProductAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">Disapprove</a>
												</td>
											</tr>
										<?php endforeach;?>
									</tbody>
								</table>
								<div><h4>Released: <?php echo $totalReleased?></h4></div>
							</div>
							
						</section>
					</section>
				<?php endif;?>
				 -------->
			 <?php if(Session::get('user')['type']== "super admin"): ?>

						<?php if(isset($loanToday)): ?>
					
							<div class="ui segment">
								<?php Flash::show();?>
									<h3>Product Advance List</h3>
								<table id="table-data3_user" class="ui celled table">
								    <thead>
								       <tr>
								       		<th>Loan #</th>
								        	<th>Lender's Name</th>
									        <th>Amount</th>
									        <!--<th>Collateral Image</th>-->
									        <th >Action</th>
									        <th>Date & Time</th>
									        <th>Group</th>
									        <th>Approve By</th>    
								      </tr>
								  	</thead>
							       <tbody>
							       	<?php foreach($loanToday['product_advance_list'] as $list) :?>
							       		<tr>
							       			<td><?php echo $list->id?></td>
							       			<td><?php echo $list->name?></td>
							       			<td><?php echo $list->amount ?></td>
							       			<!--<td>
						       					<?php if($list->collateral_img==""): ?>
						       						No Collateral Image

						       					<?php else: ?>
						       						<img src="<?php echo URL.DS.'assets/collateral/'.$list->collateral_img?>">
						       					<?php endif; ?>
							       			</td>-->

							       			<?php if($list->status=="Pending"):?>
							       			<td>
							       					<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>&productID=<?php echo $list->productID?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

							       					<!--<?php if($list->collateral_img==""): ?>
							       						Please Upload Collateral Image
							       					<?php else: ?>
							       						<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>&productID=<?php echo $list->productID?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>
							       					<?php endif; ?>-->
							       			</td>
							       		
							       			<?php endif;?>
							       			<td width="170px"><?php
							       			  $date=date_create($list->date);
			                            	echo date_format($date,"M d, Y");
			                            	$time=date_create($list->time);
			                            	echo date_format($time," h:i A");
							       			 ?></td>
							       			 <td><?php echo $list->groupName ?></td>
							       			<td><?php echo $list->approved_by ?></td>
							       			
							       

							       		</tr>
							       	<?php endforeach;?>
							       </tbody>
							    </table>
							</div>


							<div class="ui segment">
								<?php Flash::show();?>
								<h3>Cash Advance List</h3>

								<table  id="table-data10" class="ui celled table" >
								    <thead>
								       <tr>
								       		<th>Loan #</th>
								        	<th>Lender's Name</th>
								        	<th >Amount</th>
								        	<!--<th>Collateral Image</th>-->
								        	 <th >Action</th>
								        	 <th >Date & Time</th>
									        <th >Group</th>
									        <th>Approve By</th>

									     
								      </tr>
								  	</thead>
							       <tbody>
							       	<?php foreach($loanToday['cash_advance_list']  as $list) :?>
							       		<tr>
							       			<td><?php echo $list->id?></td>
							       			<td><?php echo $list->name?></td>
							       		
							       			<td><?php echo  $list->amount; ?></td>
							       			<!--<td>
							       					<?php if($list->collateral_img==""): ?>
							       						No Collateral Image
							       					<?php else: ?>
							       						<img src="<?php echo URL.DS.'assets/collateral/'.$list->collateral_img?>">
							       					<?php endif; ?>
							       				
							       			</td>-->
							       			<?php if($list->status=="Pending"):?>
							       			<td >
							       				<a class="btn btn-success btn-sm" href="/LDCashAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>
							       				<!--	<?php if($list->collateral_img==""): ?>
							       						Please Upload Collateral Image
							       					<?php else: ?>
							       							<a class="btn btn-success btn-sm" href="/LDCashAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>
							       					<?php endif; ?>-->
							       			<!--<a  class="btn btn-danger btn-sm" href="/LDCashAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">Disapprove</a>-->
							       			</td>
							       		
							       			<?php endif;?>
							       			<td width="170px" ><?php
							       			  $date=date_create($list->date);
			                            	echo date_format($date,"M d, Y");
			                            	$time=date_create($list->time);
			                            	echo date_format($time," h:i A");
							       			 ?></td>
							       			<td><?php echo $list->groupName ?></td>
							       			
							       			<td><?php echo $list->approved_by ?></td>

						

							       		</tr>
							       	<?php endforeach;?>
							       </tbody>
							    </table>
							</div>

						<?php endif; ?>
					<?php endif; ?>


				 <?php if(Session::get('user')['type']== "super admin"): ?>

						<!--- // ATTENDANCE--->
						<?php if(isset($attendanceSummary)) :?>
						<div class="ui segment">
							<h4>Attendance Today</h4>
							<table  id="table-data9"class="ui celled table" >
							    <thead>
							       <tr>
							        	<th>Date</th>
								        <th>Day</th>
								        <th>Time</th>
								        <th>Image</th>
								        <th>Full Name</th>
								        <th>Address</th>
								        <th>Notes</th>
								        <th>Late</th>
							      </tr>
							  	</thead>
						       <tbody>

						      	<?php foreach($attendanceSummary['attendance_today'] as $attendance_today) : ?>
							       	<tr>
							         <td data-label="Fullname"><?php echo $attendance_today->date?></td>
							         <td  data-label="Fullname"><?php echo $attendance_today->day?></td>
							         <td data-label="Fullname"><?php time_long($attendance_today->time) ?></td>
							         <td data-label="image">
							         	<img src="<?php echo URL.DS.'assets/'.$attendance_today->faceimage?>">
							         </td>
							         <td data-label="Fullname"><?php echo $attendance_today->fullname ?></td>
							         <td data-label="Fullname"><?php echo $attendance_today->user_address ?></td>

							         <td data-label="Action">
							          	<p><?php echo $attendance_today->notes;?></p>
							         </td>
							          <td data-label="Fullname"><?php echo $attendance_today->is_late?></td>
							        </tr>
						       	<?php endforeach;?>
						        
						       </tbody>
						    </table>
						</div>
						<?php endif;?>

				 <?php endif;?>
		

				
 <!-- cash advance history  customer-->

		<div class="ui segment">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<h3>Cash Advance List</h3>
				<div class="ui segment">
					<table id="table-data5" class="ui celled table">
					    <thead>
					       <tr>
					     	  	 <th>Name</th>
						        <th>Group</th>
						        <th>Amount</th>
						        <th>Date & Time</th>
						        <th>Collateral Image</th>
						        <th>Approve By</th>
						         <th>Status</th>
						         <th>Note</th>
					      </tr>
					  	</thead>
				       <tbody>

				       	<?php foreach($cashAdvance_history as $history) :?>
				       		<tr>


				       			<td><?php echo $history->name ?></td>
				       			<td><?php echo $history->groupName ?></td>
				       			<td><?php echo number_format($history->amount,2)  ?></td>
				       			<td><?php
				       			  $date=date_create($history->date);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($history->time);
                            	echo date_format($time," h:i A");
				       			 ?></td>

				       			<td>				  
				       		
				       			<a class="btn btn-primary btn-sm" href="/LDCashAdvance/preview_collateral/<?php echo $history->loanID;?>">Preview<br>Collateral Images</a>
				       				
				       			</td>

				       			<td><?php echo $history->approved_by ?></td>

				       			<?php if($history->status=="Pending"):?>
				       				<td><span class="label label-info"><?php echo $history->status ?></span></td>
				       			<?php elseif($history->status=="Approved" || $history->status=="Paid" ):?>
									<td><span class="label label-success"><?php echo $history->status ?></span></td>
				       			<?php else:?>
				       				<td><span class="label label-danger"><?php echo $history->status ?></span></td>
				       			<?php endif;?>

				       			<td><?php echo $history->notes ?></td>
				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>
				</div>
			</div>
		</div>



				<!-- USERS INFORMATION -->
				<div class="ui segment">
					<h4>Lender's Information</h4>
					<strong>User Type:</strong>&nbsp;<?php echo Session::get('user')['type'];?> 
					<div class="ui horizontal segments">
					    <div class="ui segment">
					      <div><strong>Personal</strong></div>
					      <div>First Name: <strong><?= $userInfo->firstname;?></strong> </div>
					      <div>Last Name: <strong><?= $userInfo->lastname;?></strong> </div>
					    </div>

					    <div class="ui segment">
					      <div><strong>Contacts</strong></div>
					      <div>Mobile : <strong><?= $userInfo->phone;?></strong></div>
					      <div>Email  : <strong><?= $userInfo->email;?></strong></div>
					    </div>

					    <div class="ui segment">
					      <div><strong>Others</strong></div>
					      <div>Status: <strong>Active</strong></div>
					      <div>Created At: 
					      	<?php
					         $date=date_create($userInfo->created_on);
	                         echo date_format($date,"M d, Y");

					       ?> 
					   	  </div>
					    </div>
				  	</div>

							<!-- summary-->
			<?php if(Session::get('user')['type']!="admin" || Session::get('user')['type'] != 'super admin'):?>
			  	<div class="ui segment">
				  		<h4><b>Member Reports</b></h4>
				  		<div class="ui grid">
				  			<div class="seven wide column one">
				  				<strong>Total Weeks:&nbsp;&nbsp;</strong>
				  				<strong><?php echo $total_weeks;?></strong>
				  				
				  			</div>
				  			<div class="seven wide column one">
				  				
				  				<strong>Total Referrals:&nbsp;&nbsp;</strong>
				  				<strong><?php echo $total_referrals->referral_total; ?></strong>
				  				
				  			</div>
				  			<div class="seven wide column one">
				  				
				  				<strong>Total Attendance:&nbsp;&nbsp;</strong>
				  				<strong><?php echo count($attendanceLog); ?></strong>
				  			
				  			</div>
				  			<div class="seven wide column one">
				  				
				  				<strong>Total Late Attendance:&nbsp;&nbsp;</strong>

				  				<strong>
				  					<?php $count_late=0;?>
				  					<?php foreach($attendanceLog as $log) :?>		 
					      				  <?php if($log->is_late==1)
					      				  		{
					      				  			$count_late=$count_late+1;
					      				  		}
					      				  ?>
				     			  	<?php endforeach;?>
				     			  	<?php echo $count_late; ?>
				  				</strong>	

				  			</div>
				  			<div class="seven wide column one">
				  				
				  				<strong>Product Loan Balance:&nbsp;&nbsp;</strong>
				  				<strong>PHP&nbsp;<?php echo $product_Advance_balance->balance-$total_productPayment->balance;?></strong>
				  				
				  			</div>
				  			<div class="seven wide column one">
				  				
				  				<strong>Cash Loan Balance:&nbsp;&nbsp;</strong>

				  				<strong>PHP&nbsp;<?php echo $cashAdvance_balance->balance-$total_cashPayment->balance;?> </strong>
				  				
				  			</div>
				  		</div>
				  	</div><!-- //summary-->
				  <?php endif;?>
	
<!-- product advance history-->
	<div class="ui segment">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<h3>Product Advance List</h3>
				<div class="ui segment">
					<table id="table-data6" class="ui celled table">

					    <thead>
					       <tr>
					     	  	 <th>Name</th>
						        <th>Group</th>
						        <th>Product</th>
						        <th>Amount</th>
						        <th>Date & Time</th>
						        <th>Collateral Image</th>
						        <th>Approve By</th>
						        <th>Status</th>
						         <th>Note</th>
					      </tr>
					  	</thead>
				       <tbody>
				       	<?php foreach($productAdvance_history as $history) :?>
				       		<tr>
				       			<td><?php echo $history->name ?></td>
				       			<td><?php echo $history->groupName ?></td>
				       			<td><?php echo $history->productName ?></td>
				       			<td><?php echo $history->amount ?></td>
				       			<td><?php
				       			  $date=date_create($history->date);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($history->time);
                            	echo date_format($time," h:i A");
				       			 ?></td>

				       			<td>
				       				<a class="btn btn-primary btn-sm" href="/LDProductAdvance/preview_collateral/<?php echo $history->loanID;?>">Preview<br>Collateral Images</a>
				       				
				       			</td>

				       			<td><?php echo $history->approved_by ?></td>

				       			<?php if($history->status=="Pending"):?>
				       				<td><span class="label label-info"><?php echo $history->status ?></span></td>
				       			<?php elseif($history->status=="Approved" || $history->status=="Paid" ):?>
									<td><span class="label label-success"><?php echo $history->status ?></span></td>
				       	
				       			<?php else:?>
				       				<td><span class="label label-danger"><?php echo $history->status ?></span></td>
				       			<?php endif;?>

				       			<td><?php echo $history->notes ?></td>
				      
				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>
				</div>
			</div>
		</div>
		

				  	<!-- id pictire -->
				  	<div class="ui segment">
				  		<h4>Id Picture</h4>
				  		<div class="ui grid">
				  			<div class="seven wide column one">
				  				<strong>Front</strong>
				  				<?php if(empty($userInfo->id_image)) :?>
				  					<p>No Front Image</p>
				  				<?php else:?>
				  					<img src="<?php echo URL.DS.'assets/'.$userInfo->id_image?>" class="id-picture">
				  				<?php endif;?>
				  			</div>
				  			<div class="seven wide column one">
				  				<strong>Back</strong>
				  				<?php if(empty($userInfo->id_image)) :?>
				  					<p>No Back Image</p>
				  				<?php else:?>
				  					<img src="<?php echo URL.DS.'assets/'.$userInfo->id_image_back?>" class="id-picture">
				  				<?php endif;?>
				  			</div>
				  		</div>
				  	</div>
				  	<!--// id pictire -->
				</div>
				<!-- // USER INFORMATION -->

				<!-- CASH PAYMENTS -->
				<div class="ui segment">
					<h4>Cash Payments</h4>
					<table id="table-data7" class="ui celled table">
						<thead>
							<th>Img</th>
							<th>Loan#</th>
							<th>Amount</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>Status</th>
							<th>Date</th>
							<th>Action</th>
						</thead>
						<tbody>
							
							<?php foreach($cashPaymentHistory as $cashPayment) :?>
								<tr>
									<td><img src="<?php echo URL.DS.'assets/'.$cashPayment->faceimage?>"></td>
									<td><?php echo $cashPayment->loan_id?></td>
									<td><?php echo $cashPayment->loan_amount?></td>
									<td><?php echo $cashPayment->principal_amount?></td>
									<td><?php echo $cashPayment->interest_amount?></td>
									<td>
										<?php if($cashPayment->is_approved == 0) :?>
											<span class="label label-info">Pending</span>
										<?php else :?>
											<span class="label label-success">Approved</span>
										<?php endif;?>
									</td>
									<td>
										<?php 
										    $date=date_create($cashPayment->created_on);
										    echo date_format($date,"Y-m-d "); 
										    $time=date_create($cashPayment->created_on);
											echo date_format($time,"h:i A");
										?>
									</td>
									<td>
										<?php 
											if(Session::get('user')['type']== 'admin' || Session::get('user')['type']== 'super admin')
											{
												if($cashPayment->is_approved == 0) {
													$href  = '/LDProductAdvance/update_status_approve_payment/';
													$href .= '?userId='.$cashPayment->payer_id;
													$href .= '&paymentId='.$cashPayment->id;
													?> 
													<a class="btn btn-success btn-sm" 
														href="<?php echo $href?>">Approve
													</a>
													<?php
												}else{
													?> 
														<p>--</p>
													<?php
												}
											}else{
												?> 
													<p>--</p>
												<?php
											}
										?>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>	
				<!-- //CASH PAYMENTS -->

				<!-- PRODUCT ADVANCE PAYMENTS -->
				<div class="ui segment">
					<h4>Product Payments</h4>
					<table id="table-data8" class="ui celled table">
						<thead>
							<th>Img</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Note</th>
							<th>Date</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php foreach($productPaymentHistory as $productPayment) :?>
								<tr>
									<td><img src="<?php echo URL.DS.'assets/'.$productPayment->faceimage?>"></td>
									<td><?php echo $productPayment->amount?></td>
									<td>
										<?php if($productPayment->is_approved == 0) :?>
											<span class="label label-info">Pending</span>
										<?php else :?>
											<span class="label label-success">Approved</span>
										<?php endif;?>
									</td>
									<td><?php echo $productPayment->note?></td>
									<td><?php 
										    $date=date_create($cashPayment->created_on);
										    echo date_format($date,"Y-m-d "); 
										    $time=date_create($cashPayment->created_on);
											echo date_format($time,"h:i A");
									?></td>
									<td>
										<?php 
											if(Session::get('user')['type']== 'admin' || Session::get('user')['type']== 'super admin')
											{
												if($cashPayment->is_approved == 0) {
													$href  = '/LDProductAdvance/update_status_approve_payment/';
													$href .= '?userId='.$productPayment->payer_id;
													$href .= '&paymentId='.$productPayment->id;
													?> 
													<a class="btn btn-success btn-sm" 
														href="<?php echo $href?>">Approve
													</a>
													<?php
												}else{
													?> 
														<p>--</p>
													<?php
												}
											}else{
												?> 
													<p>--</p>
												<?php
											}
										?>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<!--// PRODUCT ADVANCE PAYMENTS -->

				<div class="ui segment">
					<h4>Loan</h4>
					<!-- LOAN ROW START -->
					<div class="ui horizontal segments">
					    <div class="ui segment">
							<?php if(empty($cashAdvanceInfo)): ?>
								<strong>No Cash Advance</strong>
							<?php else: ?>	
							<div><strong>Cash Advance</strong></div>
						      <div> Group / Classname : <strong>
						      	<?= $cashAdvanceInfo->groupName;?></strong></div>
						      <div>Amount : <strong><?= $cashAdvanceInfo->amount;?></strong></div>
						      <div>Approved By  : <strong><?= $cashAdvanceInfo->approved_by;?></strong></div>
						      <div>Date and time  : <strong><?php
						     	 $date=date_create($cashAdvanceInfo->date);
	                            	echo date_format($date,"M d, Y");
	                            	$time=date_create($cashAdvanceInfo->time);
	                            	echo date_format($time," h:i A");
						       ?>
						      </strong>	</div>

					      		<?php if($cashAdvanceInfo->status=="Pending"):?>
				       				<div>Status  : <span class="label label-info"><?php echo $cashAdvanceInfo->status ?></span></div>
				       			<?php elseif($cashAdvanceInfo->status=="Approved" OR $cashAdvanceInfo->status=="Paid"):?>
				       				<div>Status : <span class="label label-success"><?php echo $cashAdvanceInfo->status ?></span></div>
				       			<?php else:?>
				       				<div>Status  : <span class="label label-danger"><?php echo $cashAdvanceInfo->status ?></span></div>
				       			<?php endif;?>
	 							<br>
				       			<div>Total Cash Advance : <strong>PHP<?= $cashAdvance_balance->balance;?></strong></div>
						       <div>Total Payment : <strong>PHP<?= $total_cashPayment->balance;?></strong></div>
						       <div>Balance : <strong>PHP<?php echo $cashAdvance_balance->balance-$total_cashPayment->balance;?></strong></div>
						      <br>
						      	<div><a  href="/LDCashAdvance/history/<?php echo $userInfo->id?>">History</a></div>

						      <?php endif;?>	
					    </div>

					    <div class="ui segment">
					     
						<?php if(empty($productAdvanceInfo)): ?>
							<strong>No Product Advance</strong>
						<?php else: ?>	
						<div><strong>Product Advance</strong></div>
					      <div> Group / Classname : <strong>
					      	<?= $productAdvanceInfo->groupName;?></strong></div>
					      <div>Product Name : <strong><?= $productAdvanceInfo->productName;?></strong></div>
					       <div>Amount : <strong><?= $productAdvanceInfo->amount;?></strong></div>
					      <div>Approved By  : <strong><?= $productAdvanceInfo->approved_by;?></strong></div>
					      <div>Date and time  : <strong><?php
					     	 $date=date_create($productAdvanceInfo->date);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($productAdvanceInfo->time);
                            	echo date_format($time," h:i A");
					       ?>
					      </strong></div>
					      	 	<?php if($productAdvanceInfo->status=="Pending"):?>
				       				<div>Status  : <span class="label label-info"><?php echo $productAdvanceInfo->status ?></span></div>
				       			<?php elseif($productAdvanceInfo->status=="Approved" OR $productAdvanceInfo->status=="Paid"):?>
				       				<div>Status : <span class="label label-success"><?php echo $productAdvanceInfo->status ?></span></div>
				       			<?php else:?>
				       				<div>Status : <span class="label label-danger"><?php echo $productAdvanceInfo->status ?></span></div>
				       			<?php endif;?>

				       			<br>
			       			<div>Total Product Advance : <strong>PHP<?= $product_Advance_balance->balance;?></strong></div>
					       <div>Total Payment : <strong>PHP<?= $total_productPayment->balance;?></strong></div>
					       <div>Balance : <strong>PHP<?php echo $product_Advance_balance->balance-$total_productPayment->balance;?></strong></div>
					      <br>
					      	<div><a  href="/LDProductAdvance/history/<?php echo $userInfo->id?>">History</a></div>

					      <?php endif;?>	
					    </div>
					</div>
					<!-- LOAN ROW END -->
				</div>

				<div class="ui segment">
					<h4>Schedule</h4>
					<div> 
						<?php if(empty($className)) :?>
						  	<h4>Class :&nbsp;&nbsp;&nbsp;<a href="#"><strong>No Class Name</strong></a> </h4>
						<?php else:?>
						<div>
						  <h4>Class :&nbsp;&nbsp;&nbsp;<a href="/LDClass/preview/<?php echo $className->groupid?>">
						  	<strong><?= $className->name;?></strong></a>
						  </h4>
						</div>
					  	<br>
						November:
						<?php foreach(getDayMonthOccurence(date('m') ,dayNumericToShort($className->day)) as $sched) :?>
							<a class="ui label"><?php echo $sched?></a>
						<?php endforeach;?>
						<br>Time: 
							<?php
						  		 $time=date_create($className->time);
	                        	 echo date_format($time,"h:i A");
								?>
						<br>Grace Time: 30 minutes
					</div>

					<section class="calender-container">
			  			<div class="calender">
				  			<?php
				  				$calenderDates = getDatesOfMonth(11);
				  			?>
			  				<?php $counter = 0;?>

			  				<?php foreach($calenderDates as $date) :?>
			  					<?php if($counter >= 7) :?>
			  						<div style="clear: both;"></div>
			  						<?php $counter = 0;?>
			  					<?php endif;?>

			  					<?php if(in_array($date , $classSchedule)) :?>
				  					<div style="background:green; width: 75px; 
			  							float: left; padding: 10px; margin: 5px;"> 
			  							<?php echo $date;?>
			  						</div>
			  						<?php else:?>
			  						<div style="background:#eee; width: 75px; 
			  							float: left; padding: 10px; margin: 5px;"> 
			  							<?php echo $date;?>
			  						</div>
			  					<?php endif;?>
			  					<?php $counter++;?>
			  				<?php endforeach;?>
			  				<div style="clear: both;"></div>
			  			</div>
			  			<p style="background: red; padding: 10px; color: #fff">
			  				Match the Attendance Log to Class Schedule
			  			</p>
			  		</section>
				  	<?php endif;?>
				</div>

				<!--<div class="ui segment">
					<h4>Attendance</h4>
					<table  id="table-data4" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Date</th>
						        <th>Day</th>
						        <th>Time</th>
						        <th>Image</th>
						        <th>Notes</th>
						        <th>Late</th>
					      </tr>
					  	</thead>
				       <tbody>

				       	<?php foreach($attendanceLog as $log) :?>
				       		
					       	<tr>
					         <td data-label="Fullname"><?php echo $log->date?></td>
					         <td data-label="Fullname"><?php echo $log->day?></td>
					         <td data-label="Fullname"><?php time_long($log->time) ?></td>
					         <td data-label="image">
					         	<img src="<?php echo URL.DS.'assets/'.$log->faceimage?>">
					         </td>
					         <td data-label="Action">
					          	<p><?php echo $log->notes;?></p>
					         </td>
					          <td data-label="Fullname"><?php echo $log->is_late?></td>
					        </tr>
				       	<?php endforeach;?>
				        
				       </tbody>
				    </table>
				</div>-->

				<div class="ui segment">
					<h4>History</h4>
						<?php if(empty($class_history)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table id="table-data10" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Prev</th>
						        <th>Next</th>
						        <th>Date</th>
						        <th>Approved By</th>
						        <th>Reason</th>
					      </tr>
					  	</thead>
				       <tbody>
				      
				       <?php foreach($class_history as $class_history): ?>
				       	  <tr>
				          <td data-label="Prev"><?php echo $class_history->prevgroup?></td>
				          <td data-label="Next"><?php echo $class_history->newgroup?></td>
				          <td data-label="Date">
				          <?php
				          	 	$date=date_create($class_history->created_on);
                            	echo date_format($class_history,"M d, Y");
                            	$time=date_create($class_history->created_on);
                            	echo date_format($time," h:i A");
				          ?></td>
				          <td data-label="Approved by"><?php echo $class_history->approved_by?></td>
				          <td data-label="note"><?php echo $class_history->notes?></td>
				           </tr>
				      	<?php endforeach;?>
				       
				       </tbody>
				    </table>
				    <?php endif;?>	
				</div>

			</div>
		</div>
		
	</main>

	
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Purchase Package</h4>
        </div>
        <div class="modal-body">
 			    <div  id="select_lvl_activation">
	        			<center>
	        			<?php if(isset($activation)) :?>
			        		<?php if($activation['branch_activation_lvl']!=null) :?>
						          <h2>Select Activation Level</h2>
						          <br>
						          <div> Activation code: <div style="color:green;">Available&nbsp;<?php echo $activation['activation_count_branch']->activation_count; ?></div></div>        
  								  <br>
						         	<select name="activation_lvl" id="activation_lvl"  class="form-control">
							
										       	<?php foreach($activation['branch_activation_lvl']  as $activation_levels) :?>
										       		
										

										       		<option value="<?php echo $activation_levels->activation_level;?>">
										   	   			<?php echo $activation_levels->activation_level; ?>
										      		</option>

										     	<?php endforeach;?>

									</select>
									<br>

										<button class="btn btn-success" onclick="get_activation_code()">&nbsp;&nbsp;&nbsp;Purchase&nbsp;&nbsp;&nbsp;</button>

							<?php else: ?>	
								
								 <h2>No Activation Code</h2>

							<?php endif;?>

						<?php endif;?>
		            </center>
	            </div>

	            <div id="display_code">
		            	
		            <center>
			          <h2>Activation Code</h2>
			          <h2 id="purchase_code" style="color: red;"></h2><br>
			          <button class="btn btn-success" onclick="get_activation_code_reset()">&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;</button>

		            </center>

	            </div>
	        	


        </div>
        <div class="modal-footer">
         
        </div>
      </div>
      
    </div>
  </div>
 <!-- Modal -->




<?php require_once VIEWS.DS.'lending/template/footer.php'?>


	<script> 

		$(document).ready(function()
		{
			 $("#display_code").hide();
			/*event delegation*/

			$("#search_data2").on('click' , function(evt) {

				let target = evt.target;

				if(target.classList.contains('my-users')) {

					let my_id = target.dataset.id;

								  window.location=get_url("LDUser/preview/"+my_id);		
				}

			});
		});

		function search_data(){
		
		  $.ajax({
	      method: "POST",
	      url: '/LDUser/live_search',
	      data:{data: $("#refer_name").val()},
	      success:function(response)
	      {

	      	reponse = JSON.parse(response);

	      	let html = ``;

	      	$.each(reponse , function(index , value) {

	      		html += `<div data-id='${value.id}' class='my-users'> ${value.fullname} </div>`;

	      	});
	      	
	        
	        $('#search_data2').html(html);
	        return false;			
	      }
			  });	
		}


		function get_activation_code(){

		
			 if(confirm("Confirm Purchase?")){



					$.ajax({
				      method: "POST",
				      url: '/LDActivation/purchase_code_branch',
				      data:{data: $("#activation_lvl").val()},
				      success:function(response)
				      {

				      	 console.log(response);
				      	 $('#purchase_code').html(response);
				         $("#select_lvl_activation").hide();
						 $("#display_code").show();
				       
				
				      }
					});	

			 }
		}

		function get_activation_code_reset(){

	      	 $('#purchase_code').html("");
	         $("#display_code").hide();
			 $("#select_lvl_activation").show();
			 window.location=get_url("LDUser/profile/");
		}
 			
			$(document).on('click', '#transfer_btn', function()
	{ 
			var number_check = /^[-+]?[0-9]+$/;
			var amount = prompt("Please Enter Amount:");

      		if(amount.match(number_check))			 
      		{
      			var branch_id=$(this).data("id");
      
      			if(amount!=0){

      				if(confirm("Confirm Transfer?")){



						$.ajax({
					      method: "POST",
					      url: '/LDBranch/transfer_cash_branch',
					      data:{branch_id: branch_id, amount: amount},
					      success:function(response)
					      {

					      	 console.log(response);
					      	 alert(response);
							window.location=get_url("LDUser/profile");		
					      }
						});	

					 }
      			}else{

      				alert("Invalid Input");
      			}
      		  

      		}else{

      			alert("Invalid Input Please Enter Number");
      		}

		
	});	
 			
	</script>
