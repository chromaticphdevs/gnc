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
				<h3>Create Activation Code</h3>
				<div class="ui segment">
					<!-- activation_form_container -->
					<section class="ui segment" id="activation_form_container">
						<form class="ui form" method="post" action="/LDProductAdvance/create_activation_code">

							<div class="field">
								<label>Products</label>
								<select name="productID">
							  		<option value="66">
					   	   			DBBI(Starter)&nbsp;P1000.00
						      		</option>
						      			<option value="33">
						   	   			DBBI&nbsp;P1600.00 
						      		</option>
							       	<?php foreach($productList as $productList) :?>
							       		<option value="<?php echo $productList->id;?>">
							   	   			<?php echo $productList->name;?>&nbsp;&nbsp;&nbsp;P<?php echo $productList->price;?>
							      		</option>
							     	<?php endforeach;?>
							 </select>
							</div>


							<div class="field">
								<input type="hidden" name="userType" class="form-control" 
								value="<?php echo $user_session['type']; ?>" readonly>

								<input type="number" class="form-control" name="numbers_of_code" value="1" required>
							</div>

							<!--<div class="field">
								<label>Enter Expiration Date</label>
						      	<input type="date" class="form-control" name="exp_date" required>
							</div>-->

							<div class="two fields">

								<div class="field">
									<label for="#">Branch</label>
									<select name="branch" class="selectpicker" data-live-search="true">
						               <?php foreach($branchList as $branch) : ?>
						                   <option value="<?php  echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option> 
						               <?php endforeach;?>
						          	</select>
								</div>

								<div class="field">
									<label for="#">Company</label>
									<select name="company" id="" required>
										<option value="">--Select Company</option>
										<option value="sne">Social Network</option>
										<option value="dbbi">DBBI</option>
									</select>
								</div>
							</div>

							<button class="ui button primary" type="submit">Generate Code</button> 
					    </form>
					</section>
					<!--// activation_form_container -->
					
					<section class="ui segment">
						<h3>Generated Code</h3>

						<table id="table-data6" class="ui celled table">
							<thead>
								<th>#</th>
								<th>Code</th>
								<th>Company</th>
								<th>Binary</th>
								<th>Drc</th>
			                    <th>Unilvl</th>
			                    <th>Price</th>
			                    <th>Distribution</th>
			                    <th>Max Pair</th>
			                    <th>branch</th>
			                    <th>Status</th>
							</thead>

							<tbody>
								<?php foreach($activation_code_list_unused as $key => $row) :?>
									<tr>
										<td><?php echo ++$key?> </td>
										<td><?php echo $row->activation_code?></td>
										<td><?php echo strtoupper($row->company ?? 'un-tag')?></td>
										<td><?php echo $row->binary_pb_amount?></td>
										<td><?php echo $row->drc_amount?></td>
										<td><?php echo $row->unilvl_amount?></td>
										<td><?php echo $row->price?></td>
										<td><?php echo $row->com_distribution?></td>
										<td><?php echo $row->max_pair?></td>
										<th><?php echo $row->branch_id?></th>
										<?php if($row->status=="Unused"): ?>
		                           		<td><span class="label label-warning"><?php echo $row->status ?></span></td>
					       				<?php else:?>
					       				<td><span class="label label-success"><?php echo $row->status ?></span></td>	
					       				<?php endif;?>
									</tr>
								<?php endforeach?>
							</tbody>
						</table>
					</section

					<!-- used codes-->
					<section class="ui segment">

						<table id="table-data7" class="ui celled table">
							<thead>
								<th>#</th>
								<th>Code</th>
								<th>Company</th>
								<th>Binary</th>
								<th>Drc</th>
			                    <th>Unilvl</th>
			                    <th>Price</th>
			                    <th>Distribution</th>
			                    <th>Max Pair</th>
			                    <th>Status</th>
							</thead>

							<tbody>
								<?php foreach($activation_code_list_used as $key => $row) :?>
									<tr>
										<td><?php echo ++$key?> </td>
										<td><?php echo $row->activation_code?></td>
										<td><?php echo  strtoupper($row->company ?? 'un-tag') ?></td>
										<td><?php echo $row->binary_pb_amount?></td>
										<td><?php echo $row->drc_amount?></td>
										<td><?php echo $row->unilvl_amount?></td>
										<td><?php echo $row->price?></td>
										<td><?php echo $row->com_distribution?></td>
										<td><?php echo $row->max_pair?></td>
											<?php if($row->status=="Unused"): ?>
		                           		<td><span class="label label-warning"><?php echo $row->status ?></span></td>
					       				<?php else:?>
					       				<td><span class="label label-success"><?php echo $row->status ?></span></td>	
					       				<?php endif;?>
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
