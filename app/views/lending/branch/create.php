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
				<section class="ui segment">
        		 <?php Flash::show();?>
				<h3>Create Class</h3>
				<div class="ui segment">
					<form class="ui form" method="post">
				      <div class="field">
				        <label>Branch Name</label>
				        <input type="text" name="branch_name" placeholder="Branch Name" required>
				      </div>
				       <div class="field">
				        <label>Branch Address</label>
				        <input type="text" name="branch_address" placeholder="Branch Address" required>
				      </div>
				       <div class="field">
				        <label>Note</label>
				        <input type="text" name="note" placeholder="Note" >
				      </div>

				
				      <button class="ui button primary" type="submit">Create Branch</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
