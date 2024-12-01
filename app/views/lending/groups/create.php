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
				<h3>Create Group</h3>
				<div class="ui segment">
					<form class="ui form" method="post">
				      <div class="field">
				        <label>Group Name</label>
				        <input type="text" name="group_name" placeholder="Group Name">
				      </div>

				      <div class="field">
				        <label>Branch</label>
				        <select name="branchid" class="form-control" required>
				        	<option value="">--Select</option>
				        <?php foreach($branchList as $row) :?>
				        	<option value="<?php echo $row->id?>"><?php echo $row->branch_name?></option>
				        <?php endforeach;?>
				        </select>
				      </div>

				      <button class="ui button primary" type="submit">Create Class</button>
				    </form>
				</div>


				<h3>Group List</h3>
				<div class="ui segment">
					<table class="ui table">
						<thead>
							<th>Name</th>
							<th>Branch</th>
							<th>Schedules</th>
						</thead>

						<tbody>
							<?php foreach($groupList as $row) :?>
								<tr>
									<td><?php echo $row->group_name?></td>
									<td><?php echo $row->branch_name?></td>
									<td><a href="/LDGroup/preview/?groupid=<?php echo $row->id?>">View</a></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
