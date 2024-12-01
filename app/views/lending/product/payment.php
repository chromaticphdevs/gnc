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
				<h3>Product Advance</h3>
				<div class="ui segment">
					<form class="ui form" method="post" action="/LDProductAdvance/send_payment">
				      <div class="field">
				        <label>Lenders Name</label>

				   
							<input type="hidden" name="userId" class="form-control" 
							value="<?php echo $userinfo->id; ?>" readonly>

							<input type="text" name="username" class="form-control" 
							value="<?php echo $userinfo->firstname.' '.$userinfo->lastname; ?>" readonly>
							<br>
						      <label>Amount</label>
							<input type="number" name="amount" class="form-control" required>
				      </div>

 					
				      <fieldset class="field">
				     
						  <div class="field">
						  	<label>Note</label>
						   	<textarea name="note"  rows="4" cols="50" required></textarea>
						  </div>
				      </fieldset>
				      <button class="ui button primary" type="submit">Send Payment</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
