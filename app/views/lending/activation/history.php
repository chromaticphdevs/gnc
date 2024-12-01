<?php require_once VIEWS.DS.'lending/template/header.php'?>


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
		  </a>
		  	<?php if(Session::get('user')['type']== "super admin"):?>
				   <a class="item" href="/LDProductAdvance/create_activation_code">
						Create Activation Code
				  </a>
				  <a class="item" href="/LDActivation/history_activation_code">
						Activation Code History
				  </a>
			<?php endif; ?>
		</div>
		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
		
				<div class="ui segment">
			
					
					<section class="ui segment">
						<h3>History</h3>

						<table id="table-data6" class="ui celled table">
							<thead>
								<th>#</th>
								<th>Code</th>
			                    <th>branch</th>
								<th>User ID</th>
								<th>Fullname</th>
			                    <th>Expiration Date</th>
			                    <th>Activated Date & Time</th>
			                    <th>Status</th>
							</thead>

							<tbody>
								<?php foreach($activation_code_history as $key => $row) :?>
									<tr>
										<td><?php echo ++$key?> </td>
										<td><?php echo $row->activation_code?></td>
										<th><?php echo $row->branch_id?></th>
										<td><?php echo $row->userID?></td>
										<td><?php echo $row->fullname?></td>
										<td><?php echo $row->expiration_date?></td>
										<td>
											<?php
											if(!empty($row->activated_date) && !empty($row->activated_time)  )
											{
												$date=date_create($row->activated_date);
				                            	echo date_format($date,"M d, Y");
				                            	$time=date_create($row->activated_time);
				                            	echo date_format($time," h:i A");
											}
											

											?>
										</td>
										<td>
											<?php if($row->status=="Unused"): ?>

			                           			<span class="label label-warning"><?php echo $row->status ?></span>
			                           			

			                           		<?php elseif($row->status=="Used"): ?>

			                           			<span class="label label-success"><?php echo $row->status ?></span>	

						       				<?php else:?>

						       					<span class="label label-danger"><?php echo $row->status ?></span>	

						       				<?php endif;?>
						       				<br><br>
						       				<?php if($row->status2=="Sold"): ?>

			                           			<span class="label label-success"><?php echo $row->status2 ?></span>	

							       			<?php else:?>

							       				<span class="label label-warning"><?php echo $row->status2 ?></span>	

							       			<?php endif;?>
					       				</td>

									</tr>
								<?php endforeach?>
							</tbody>
						</table>
					</section>

				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
