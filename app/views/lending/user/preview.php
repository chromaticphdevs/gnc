<?php require_once VIEWS.DS.'lending/template/header.php'?>
<style type="text/css">
	table img
	{
		width: 100px;
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
		  <?php if(Session::get('user')['type']=="cashier"):?>
			   <a class="item" href="/LDCashier/index">
				  BACK
			   </a> 
		   <?php else:?>

			   	 <a class="item">
				   <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
			
			   </a> 
			<?php endif;?>


		</div>


		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<h3>User View</h3>
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
					      <div>Created At: <?php
					         $date=date_create($userInfo->created_on);
                             echo date_format($date,"M d, Y");

					       ?> </div>
					    </div>
					  </div>
					  <div>
					 </div>
				</div>

				 


		 	    <?php if(Session::get('user')['type']=="cashier"):?>
				 
				 	<a class="btn btn-primary btn-sm" href="/LDPayment/make_payment_cashier/<?php echo $userInfo->id; ?>">&nbsp;&nbsp;&nbsp;Post Payment&nbsp;&nbsp;&nbsp;</a>

			   <?php else:?>
						<a class="btn btn-primary btn-sm" href="/LDPayment/make_payment/<?php echo $userInfo->id; ?>">&nbsp;&nbsp;&nbsp;Post Payment&nbsp;&nbsp;&nbsp;</a>
				<?php endif;?>


<div class="ui segment">
		<h4>Loan</h4>
				<!-- product advance history-->
	<div class="ui segment">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<?php Flash::show();?>
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
						        <th>Approve By</th>
						        <!--<th>Collateral Image</th>-->
						        <th>Status</th>
						        <th>Note</th>

						  <?php if(Session::get('user')['type']!="cashier"):?>     		
						        <th>Action</th>
						  <?php endif;?>     		    

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
				       			<td><?php echo $history->approved_by ?></td>
				       			<!--<td>
				       					<?php if($history->collateral_img==""): ?>
				       						No Collateral Image
				       					<?php else: ?>
				       						<img src="<?php echo URL.DS.'assets/collateral/'.$history->collateral_img?>">
				       					<?php endif; ?>
				       				
				       			</td>-->
				       			<?php if($history->status=="Pending"):?>
				       				<td><span class="label label-info"><?php echo $history->status ?></span></td>
				       			<?php elseif($history->status=="Approved"):?>
				       			
				       				        <?php if(($history->amount-$history->payment<=0)):?>
				       				        	<td><span class="label label-success">Paid</span></td>
				       				        <?php else:?>
				       							<td><span class="label label-success"><?php echo $history->status ?></span></td>
				       						<?php endif;?>	

				       			<?php else:?>
				       				<td><span class="label label-danger"><?php echo $history->status ?></span></td>
				       			<?php endif;?>

				       			<td><?php echo $history->notes ?></td>

				      			<?php if(Session::get('user')['type']!="cashier"):?>  

						       			<?php if($history->status=="Pending"):?>
						       			<td>
						       						<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>&productID=<?php echo $history->productID?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

						       								<a  class="btn btn-danger btn-sm" href="/LDProductAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>">Disapprove</a>

						       				<!--<?php if($history->collateral_img==""): ?>
						       						Please Upload Collateral Image
						       					<?php else: ?>
						       								<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>&productID=<?php echo $history->productID?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

						       								<a  class="btn btn-danger btn-sm" href="/LDProductAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>">Disapprove</a>
						       					<?php endif; ?>-->
						       			
						       			</td>
						       			<?php else:?>
						       				<td></td>
						       			<?php endif;?>
						       	<?php endif;?>		
				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>
				</div>
			</div>
		</div>


					<!-- Cash advance history-->
			<div class="ui segment">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<h3>Cash Advance List</h3>
				<?php Flash::show();?>
				<div class="ui segment">
					<table id="table-data5" class="ui celled table">
					    <thead>
					       <tr>
					     	  	<th>Name</th>
						        <th>Group</th>
						        <th>Amount</th>
						        <th>Date & Time</th>
						        <th>Approve By</th>
						        <!--<th>Collateral Image</th>-->
						        <th>Status</th>
						        <th>Note</th>

						  <?php if(Session::get('user')['type']!="cashier"):?>     		
						        <th>Action</th>
						  <?php endif;?>   

					      </tr>
					  	</thead>
				       <tbody>

				       	<?php $payer_id_payment=0;?>
				       	<?php foreach($cashAdvance_history as $history) :?>
				       		<tr>

								<?php $payer_id_payment=$history->userID;?>
				       			<td><?php echo $history->name ?></td>
				       			<td><?php echo $history->groupName ?></td>
				       			<td><?php echo $history->amount ?></td>
				       			<td><?php
				       			  $date=date_create($history->date);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($history->time);
                            	echo date_format($time," h:i A");
				       			 ?></td>
				       			<td><?php echo $history->approved_by ?></td>
				       			<!--<td>
				       					<?php if($history->collateral_img==""): ?>
				       						No Collateral Image
				       					<?php else: ?>
				       						<img src="<?php echo URL.DS.'assets/collateral/'.$history->collateral_img?>">
				       					<?php endif; ?>
				       				
				       			</td>-->
				       			<?php if($history->status=="Pending"):?>
				       				<td><span class="label label-info"><?php echo $history->status ?></span></td>
				       			<?php elseif($history->status=="Approved"):?>

				       				        <?php if(($history->amount-$history->payment<=0)):?>
				       				        	<td><span class="label label-success">Paid</span></td>
				       				        <?php else:?>
				       							<td><span class="label label-success"><?php echo $history->status ?></span></td>
				       						<?php endif;?>	

				       			<?php else:?>
				       				<td><span class="label label-danger"><?php echo $history->status ?></span></td>
				       			<?php endif;?>

				       			<td><?php echo $history->notes ?></td>

				       			<?php if(Session::get('user')['type']!="cashier"):?>  

						       			<?php if($history->status=="Pending"):?>
						       			<td>

						       				<a class="btn btn-success btn-sm" href="/LDCashAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

						       								<a  class="btn btn-danger btn-sm" href="/LDCashAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>">Disapprove</a>
						       					<!--<?php if($history->collateral_img==""): ?>
						       						Please Upload Collateral Image
						       					<?php else: ?>
						       								<a class="btn btn-success btn-sm" href="/LDCashAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

						       								<a  class="btn btn-danger btn-sm" href="/LDCashAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $history->loanID ?>&payer_id=<?php echo $history->userID ?>">Disapprove</a>
						       					<?php endif; ?>-->
						       		
						       			</td>
						       			<?php else:?>
						       				<td></td>
						       			<?php endif;?>

						       	<?php endif;?>		

				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>
				</div>
			</div>
		</div>


			</div>

<?php if(Session::get('user')['type']!="cashier"):?>  
				 <div class="ui segment">	
		
					<h4>Payments</h4>
					<div class="ui horizontal segments">
					    <div class="ui segment">
					    

						<?php if(empty($productAdvancePaymentInfo)): ?>
							<strong>No Cash Advance Payment</strong>
						<?php else: ?>	
						<div><strong>Cash Advance Payments</strong></div>
							<table class="ui celled table">
					  		  <thead>
					     		  <tr>
						     	  	<th width="70%">Information</th>
							       
					   		   </tr>
					  		  </thead>
				     	    <tbody>
				     	    	  	<?php foreach($cashAdvancePaymentInfo as $Info) :?>
				       		<tr>
					       		<td>
					       			 <div>Amount : <strong><?php echo $Info->loan_amount ?></strong></div>

					       			 <div>Status : <strong>
					       			 	<?php if($Info->is_approved==0):?>
					       				<span class="label label-info">Pending</span>
					       				<?php elseif($Info->is_approved==1):?>
					       				<span class="label label-success">Approved</span>
					       				<?php endif;?></strong></div>

					       			<!-- <div>Approve By : <strong><?php echo $Info->approved_by ?></strong></div>-->
 									 <div>Date : <strong>
					       			 	<?php $date=date_create($Info->created_on);
	                            		echo date_format($date,"M d, Y");?>		
	                            	 </strong></div>

	                            	 	 <div>Time : <strong>
					       			 	<?php $time=date_create($Info->created_on);
	                            		echo date_format($time," h:i A");?>
	                            	 </strong></div>


	                            	 <div><a   href="/LDCashAdvance/payment_history/<?php echo $userInfo->id?>">History</a></div>
	                            </td>
					       		</tr>
					       		<?php break;?>
					       	<?php endforeach;?>
				       </tbody>
				    </table>

					      <?php endif;?>	
					    </div>
					 
					    <div class="ui segment">
					     
						<?php if(empty($productAdvancePaymentInfo)): ?>
							<strong>No Product Advance Payment</strong>
						<?php else: ?>	
						<div><strong>Product Advance Payments</strong></div>
							<table class="ui celled table">
					  		  <thead>
					     		  <tr>
						     	  	<th width="70%">Information</th>
							          
					   		  	 </tr>
					  		  </thead>
				     	    <tbody>
				     	    	  	<?php foreach($productAdvancePaymentInfo as $Info) :?>
				       		<tr>
					       		<td>
					       			 <div>Amount : <strong><?php echo $Info->amount ?></strong></div>

					       			 <div>Status : <strong>
					       			 	<?php if($Info->is_approved==0):?>
					       				<span class="label label-info">Pending</span>
					       				<?php elseif($Info->is_approved==1):?>
					       				<span class="label label-success">Approved</span>
					       				<?php endif;?></strong></div>

					       			 <div>Approve By : <strong><?php echo $Info->approved_by ?></strong></div>

					       			 <div>Date : <strong>
					       			 	<?php $date=date_create($Info->created_on);
	                            		echo date_format($date,"M d, Y");?>		
	                            	 </strong></div>

	                            	 	 <div>Time : <strong>
					       			 	<?php $time=date_create($Info->created_on);
	                            		echo date_format($time," h:i A");?>		
	                            	 </strong></div>

	                            	 <div><a   href="/LDProductAdvance/payment_history/<?php echo $userInfo->id?>">History</a></div>
	                            </td>
					       		</tr>
					       		<?php break;?>
					       	<?php endforeach;?>
				       </tbody>
				    </table>	

					      <?php endif;?>	
					    </div>
							</div>
					</div>


					 <div class="ui segment">
					<h4>Schedule</h4>
					<div> 

					  	<?php if(empty($className)) :?>
					  		
					  		<h4>Class :&nbsp;&nbsp;&nbsp;<a href="#"><strong>No Class Name</strong></a> </h4>
					  	<?php else:?>
					  		<div><h4>Class :&nbsp;&nbsp;&nbsp;<a href="/LDClass/preview/<?php echo $className->groupid?>"><strong><?= $className->name;?></strong></a></h4></div>
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
							<div><a class="btn btn-primary btn-sm" href="/LDClass/updateClass/?userId=<?php echo $userInfo->id?>&groupId=<?php echo $className->groupid?>">Change Group</a></div>
					  	<?php endif;?>	
					</div>
					</div>


					<div class="ui segment">
					<h4>Attendance</h4>

						<?php if(empty($attendancelog)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table id="table-data" class="ui celled table">
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
					         <td data-label="Fullname"><?php echo $log->time?></td>
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
				       	<?php endif;?>	
				    </table>


				</div>

				<div class="ui segment">
					<h4>History</h4>
						<?php if(empty($class_history)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table id="table-data2" class="ui celled table">
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
				      
				       <?php foreach($class_history as $data): ?>
				       	  <tr>
				          <td data-label="Prev"><?php echo $data->prevgroup?></td>
				          <td data-label="Next"><?php echo $data->newgroup?></td>
				          <td data-label="Date">
				          <?php
				          	 	$date=date_create($data->created_on);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($data->created_on);
                            	echo date_format($time," h:i A");
				          ?></td>
				          <td data-label="Approved by"><?php echo $data->approved_by?></td>
				          <td data-label="note"><?php echo $data->notes?></td>
				           </tr>
				      	<?php endforeach;?>
				       
				       </tbody>
				    </table>
				    <?php endif;?>	
				</div>

 <?php endif;?>	
			
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
