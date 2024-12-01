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
				<h3>History</h3>
				<div class="ui segment">
					<table id="table-data" class="ui celled table">
					    <thead>
					       <tr>
					     	  	 <th>Name</th>
						        <th>Group</th>
						        <th>Amount</th>
						        <th>Date & Time</th>
						        <th>Approve By</th>
						         <th>Status</th>
						         <th>Note</th>
					      </tr>
					  	</thead>
				       <tbody>
				       	<?php foreach($history as $history) :?>
				       		<tr>
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

				       			<?php if($history->status=="Pending"):?>
				       				<td><span class="label label-info"><?php echo $history->status ?></span></td>
				       			<?php elseif($history->status=="Approved"):?>
				       				<td><span class="label label-success"><?php echo $history->status ?></span></td>
				       			<?php else:?>
				       				<td><span class="label label-danger"><?php echo $history->status ?></span></td>
				       			<?php endif;?>

				       			<td><?php echo $history->notes ?></td>
				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>

				    <br><br>
				     			<a class="btn btn-primary btn-sm" href="/LDPayment/make_payment/<?php echo $userID ?>">Add Payment</a>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
