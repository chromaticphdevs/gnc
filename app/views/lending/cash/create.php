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
				<h3>Cash Advance</h3>
				<div class="ui segment">
					<form class="ui form" method="post" action="/LDCashAdvance/create">
				      <div class="field">
				        <label>Lenders Name</label>


				        <?php if($user_session['type']=="admin"):?>

				          <select name="userid" class="selectpicker" data-live-search="true">
						       	<?php foreach($userList as $user) :?>
						      		<option value="<?php echo $user->userID;?>">
						      	<?php echo $user->NAME;?>
						      		
						      	</option>
						     	<?php endforeach;?>
						 </select>
						  	<input type="hidden" name="userType" class="form-control" 
							value="<?php echo $user_session['type']; ?>" readonly>
						<?php else:?>

							<input type="text" name="username" class="form-control" 
							value="<?php echo $username->firstname.' '.$username->lastname; ?>" readonly>
                         	<input type="hidden" name="userType" class="form-control" 
							value="<?php echo $user_session['type']; ?>" readonly>

                         	<input type="hidden" name="userid" class="form-control" 
							value="<?php echo $user_session['id']; ?>" readonly>
						<?php endif;?>
				      </div>
 					<div class="field">
				        <label>Amount</label>
				        <input type="number" name="amount">
				      </div>
				      <fieldset class="field">
				     
					     <!-- <div class="two fields">
						    <div class="field">
						      <label>Date</label>
						    <input type="date" name="date">
						    </div>
						    <div class="field">
						      <label>Time</label>
						      <input type="time" name="time">
						    </div>
						  </div>-->

						  <div class="field">
						  	<label>Note</label>
						   	<textarea name="note"  rows="4" cols="50"></textarea>
						  </div>
				      </fieldset>
				      <button class="ui button primary" type="submit">Request Cash</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
