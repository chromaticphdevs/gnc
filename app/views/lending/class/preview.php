<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">



  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Lender</h4>
        </div>
        <div class="modal-body">
         	<div class="ui segment">
         		<?php Flash::show();?>
					<h4>Lenders List</h4>
					<table  class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Fullname</th>
						        <th>Email</th>
						        <th>Phone</th>
						        <th>Action</th>
					      </tr>
					  	</thead>
				       <tbody>

					<?php foreach($noClass as $users): ?>
				        <tr>
				          <td data-label="Fullname"><?php echo $users->firstname.' '.$users->middlename.'. '. $users->lastname; ?></td>
				          <td data-label="Email"><?php echo $users->email?></td>
				          <td data-label="Phone"><?php echo $users->phone?></td>
				          <td data-label="Action"><a class="btn btn-success btn-sm" href="/LDClass/add_user/?userId=<?php echo $users->id?>&groupId=<?php echo $classId?>">Add Lender</a></td>
				        </tr>

				      	<?php endforeach;?>
				      

				       </tbody>
				    </table>
				</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--end  Modal code -->


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
				<h3>Class View</h3>
				<div class="ui segment">
					<h4>Class Info</h4>
					<div class="ui horizontal segments">
					    <div class="ui segment">
					      <div><strong>Class</strong></div>
					      <div>Class Name:<strong><?php echo $class->name?></strong> </div>
					      <div>Date Createad:<strong>
					      	<?php 
					      
					      	  $date=date_create($class->created_on);
                              echo date_format($date,"M d, Y");
                              echo " ";
                              $time=date_create($class->created_on);
                              echo date_format($time,"h:i A");
					      	?>
					      </strong> </div>
					    </div>

					    <div class="ui segment">
					      <div><strong>Schedule</strong></div>
					      <div><a href="#">Preview</a></div>
					      <div>Upnext (Nov 20)</div>
					    </div>

					    <div class="ui segment">
					      <div><strong>Others</strong></div>
					      <div>Total Attendees: 33</div>
					      <div><a href="#">History</a> </div>
					    </div>
					  </div>
				</div>

				<a type="button" class="btn btn-info btn-sm" href="/LDClass/updateClass_info/<?php echo $class->id?>">Update Class</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add Lender</button>

				<div class="ui segment">
					<h4>Schedule</h4>
					<div>
						November:
						<?php foreach($schedule as $sched) :?>
							<a class="ui label"><?php echo $sched?></a>
						<?php endforeach;?>
				
					</div>
				</div>


				<div class="ui segment">
					<h4>Conflicts</h4>
					<div>
							<?php if(empty($conflict)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
						<?php foreach($conflict as $list) :?>
						
							<a class="ui label" href="/LDClass/preview/<?php echo $list->id?>"><?php echo $list->name?></a>
						<?php endforeach;?>
					<?php endif; ?>
					</div>
				</div>

				<div class="ui segment">
					<h4>Class List</h4>
						<?php if(empty($classList)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table id="table-data" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Fullname</th>
						        <th>Email</th>
						        <th>Phone</th>
						        <th>Action</th>
					      </tr>
					  	</thead>
				       <tbody>

				        	<?php foreach($classList as $users): ?>
				        <tr>
				          <td data-label="Fullname"><?php echo $users->firstname.' '.$users->middlename.'. '. $users->lastname; ?></td>
				          <td data-label="Email"><?php echo $users->email?></td>
				          <td data-label="Phone"><?php echo $users->phone?></td>
				          <td data-label="Action"><a  class="btn btn-primary btn-sm"  href="/LDUser/Preview/<?php echo $users->id?>">Preview</a></td>
				        </tr>

				      	<?php endforeach;?>
				        </tr>
				       
				       </tbody>
				    </table>

				<?php endif; ?>
				</div>
			</div>
		
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
