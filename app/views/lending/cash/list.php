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
				<h3>Cash Advance List</h3>
				<div class="ui segment">
					<table style="width:100%" id="table-data" class="ui celled table">
					    <thead>
					       <tr>
					        	<th width="13%">Lender's Name</th>
						        <th width="10%">Group</th>
						        <th width="5%">Amount</th>
						        <th width="10%">Date & Time</th>
						        <th width="12%">Approve By</th>
						         <th width="5%">Status</th>
						         <th width="20%">Note</th>
						          <th width="15%">Action</th>
					      </tr>
					  	</thead>
				       <tbody>
				       	<?php foreach($list as $list) :?>
				       		<tr>
				       			<td><?php echo $list->name?></td>
				       			<td><?php echo $list->groupName ?></td>
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
				       			<a class="btn btn-success btn-sm" href="/LDCashAdvance/update_status_approve/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>

				       			<a  class="btn btn-danger btn-sm" href="/LDCashAdvance/update_status_disapprove/?userId=<?php echo Session::get('user')['id']?>&loanId=<?php echo $list->id ?>">Disapprove</a>
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
