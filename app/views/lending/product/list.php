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
					        	<th>Lender's Name</th>
						        <th>Group</th>
						        <th>Product Name</th>
						         <th>Amount</th>
						        <th>Date & Time</th>
						        <th>Approve By</th>
						        <th >Status</th>
						        <th >Note</th>
						        <th >Action</th>
					      </tr>
					  	</thead>
				       <tbody>
				       	<?php foreach($list as $list) :?>
				       		<tr>
				       			<td><?php echo $list->name?></td>
				       			<td><?php echo $list->groupName ?></td>
				       			<td><?php echo $list->productName ?></td>
				       			<td><?php echo $list->amount ?></td>
				       			<td><?php
				       			  $date=date_create($list->date);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($list->time);
                            	echo date_format($time," h:i A");
				       			 ?></td>
				       			<td><?php echo $list->approved_by ?></td>

				       			<?php if($list->status=="Pending"):?>
				       				<td><span class="label label-info"><?php echo $list->status ?></span></td>
				       			<?php elseif($list->status=="Approved"):?>
				       				<td><span class="label label-success"><?php echo $list->status ?></span></td>
				       			<?php else:?>
				       				<td><span class="label label-danger"><?php echo $list->status ?></span></td>
				       			<?php endif;?>

				       			<td><?php echo $list->notes ?></td>

				       			<?php if($list->status=="Pending"):?>
				       			<td>
				       			<a class="btn btn-success btn-sm" href="/LDProductAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id?>&productID=<?php echo $list->productID?>&payer_id=<?php echo $list->userID?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

				       			<a  class="btn btn-danger btn-sm" href="/LDProductAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">Disapprove</a>
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
