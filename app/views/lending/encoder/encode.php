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
		     <a class="item">
		 &nbsp; &nbsp;<?php echo Session::get('user')['type'];?>
		  </a>
		</div>


		<div class="ui grid">
		
			<div class="twelve wide column">
				<h3>Encode userid</h3>
				<div class="ui segment">
					<form class="ui form" method="post" action="/LDEncoder/register_account">
						<div class="field">
							<label>Firstname</label>
							<input type="text" name="firstname">
						</div>

						<div class="field">
							<label>Lastname</label>
							<input type="text" name="lastname">
						</div>

						<div class="field">
							<label>Sponsor</label>
							<select name="direct_sponsor" id="direct_sponsor" onchange="preview_user_data()" class="selectpicker" data-live-search="true">
						     	<?php foreach($userList as $key => $user) :?>
									<option data-subtext="<?php echo $user->username; ?>" value="<?php echo $user->id?>">
										<?php echo $user->fullname; ?>
									</option>
								<?php endforeach;?>
						    </select>
						</div>
						<br>	<br>
						<input type="submit" name=""
							class="btn btn-primary" value="Create User">
				    </form>
				</div>
				<?php Flash::show();?>
				<div class="ui segment">
					<h3>Accounts that are created today</h3>
					<table id="table-data6" class="ui celled table">
						<thead>
							<th>#</th>
							<th>Fullname</th>
							<th>Date</th>
						</thead>

						<tbody>
							<?php foreach($createUsers as $key => $user) :?>
								<tr>
									<td><?php echo ++$key?></td>
									<td><?php echo $user->fullname?></td>
									<td><?php echo date_long($user->created_on)?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
