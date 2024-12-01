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
			<?php endif; ?>
		</div>
		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<h3>Create Activation Code</h3>
				<div class="ui segment">
			
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
