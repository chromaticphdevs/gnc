<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">

	<main class="ui container">
		<div class="ui inverted menu">
		  <a class="active item">
		    Home
		  </a>
		  <a class="item">
		    Messages
		  </a>
		  <a class="item">
		    Friends
		  </a>
		</div>


		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<h3>Product Advance List</h3>
				<div class="ui segment">
					<table id="table-data" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Amount</th>
						        <th>Status</th>
						        <th>Approve By</th>
						        <th >Date & Time</th>
						        <th >Note</th>
						        <th >Action</th>
					      </tr>
					  	</thead>
				       <tbody>
				       	<?php foreach($payment_history as $info) :?>
				       		<tr>
				       			<td><?php echo $info->amount?></td>
				       			<?php if($info->is_approved==0):?>
				       				<td><span class="label label-info">Pending</span></td>
				       			<?php else:?>
				       					<td><span class="label label-success">Approved</span></td>
				       			<?php endif;?>
				       				<td><?php echo $info->approved_by ?></td>
				       			<td><?php
				       			  $date=date_create($info->created_on);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($info->created_on);
                            	echo date_format($time," h:i A");
				       			 ?></td>

				       			<td><?php echo $info->note ?></td>

				       			<?php if($info->is_approved==0 && Session::get('user')['type']=="admin"):?>
				       			<td>
				       			<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve_payment/?userId=<?php echo  $info->payer_id?>&paymentId=<?php echo $info->id ?>">Approve</a>
				       			</td>
				       			<?php else:?>
				       				<td></td>
				       			<?php endif;?>
				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
