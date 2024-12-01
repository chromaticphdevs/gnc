<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body>

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


		  <div class="ui segment">

	  		<select name="preview_user" id="preview_user" onchange="preview_user_data()" class="selectpicker" data-live-search="true">
		       	<?php foreach($userList as $user) :?>
		      		<option value="<?php echo $user->userID;?>">
		      	<?php echo $user->NAME;?>
		      		
		      	</option>
		     	<?php endforeach;?>
		    </select>
		    <br><br>

			<div class="twelve wide column">
				<center><h1>Edit Address</h1></center>
				<br>
				<?php
					 if(isset($_GET['userID']))
					 {
						Flash::set($userInfo->firstname.' '.$userInfo->lastname,'success'); 
				     }
				?>
				 <?php Flash::show();?>
			</div>
			 <div class="field">

			<label>full address</label>
			<?php die(var_dump($userInfo));?>
			<input type="text" value="<?php echo $userInfo->address; ?>">

			</div>

		
		</div>
		
</main>

	<script>
	function preview_user_data() {
		
		  var id = document.getElementById("preview_user").value
		  window.location=get_url("LDUser/encoder/?userID="+id);

		  }
		
	</script>
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
