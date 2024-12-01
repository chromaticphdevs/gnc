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
				<?php Flash::show();?>
				<h3>Class List</h3>
				<div class="ui segment">
					<table id="table-data" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Class Name</th>
						        <th>Day</th>
						        <th>Time</th>
						        <th>Action</th>
					      </tr>
					  	</thead>
				       <tbody>
				       	<?php foreach($classList as $class) :?>
				       		<tr>
				       			<td><?php echo $class->name?></td>
				       			<td><?php echo dayNumericToLong($class->day) ?></td>
				       			<td><?php
				       			   $date=date_create($class->time);
                                   echo date_format($date,"h:i A");
				       			 ?></td>
				       			<td data-label="Edit"><a  class="btn btn-primary btn-sm" href="/LDClass/preview/<?php echo $class->id?>">Preview</a></td>
				       		</tr>
				       	<?php endforeach;?>
				       </tbody>
				    </table>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
