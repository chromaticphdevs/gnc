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
				<h4>Lenders List</h4>
				<section class="ui segment">
					<table  id="table-data" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Fullname</th>
						        <th>Email</th>
						        <th>Phone</th>
						        <th>Action</th>
					      </tr>
					  	</thead>
				       <tbody>

				       	<?php foreach($userList as $user): ?>
				        <tr>
				          <td data-label="Fullname"><?php echo $user->firstname.' '.$user->middlename.'. '. $user->lastname; ?></td>
				          <td data-label="Email"><?php echo $user->email?></td>
				          <td data-label="Phone"><?php echo $user->phone?></td>
				          <td data-label="Action"><a  class="btn btn-primary btn-sm" href="/LDUser/Preview/<?php echo $user->id?>">Preview</a></td>
				        </tr>

				      	<?php endforeach;?>
				       </tbody>
				    </table>
				</section>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
