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
					<form class="ui form" method="post" action="/LDProductAdvance/create">
				      <div class="field">
				        <label>Lenders Name</label>

				        <?php if($user_session['type']=="admin" || $user_session['type']=="super admin"):?>

				          <select name="userid" class="selectpicker" data-live-search="true" >
						       	<?php foreach($userList as $list) :?>
						      		<option value="<?php echo $list->userID;?>">
						      	<?php echo $list->NAME;?>
						      		
						      	</option>
						     	<?php endforeach;?>
						 </select><br>
						   <label>Products</label>
						  <select name="productID">
						  			<option value="two_products">
						   	   			DBBI&nbsp;P1600.00 &nbsp;&nbsp;&&nbsp;&nbsp;DBBI(Starter)&nbsp;P1000.00
						      		</option>
						       	<?php foreach($productList as $productList) :?>
						       		<option value="<?php echo $productList->id;?>">
						   	   			<?php echo $productList->name;?>&nbsp;&nbsp;&nbsp;P<?php echo $productList->price;?>

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
							<br>
						    <label>Products</label>
						  	<select name="productID">
						  	<?php foreach($productList as $productList) :?>
						      	<option value="<?php echo $productList->id;?>">
						      	<?php echo $productList->name;?>	
						      	</option>
						     <?php endforeach;?>
						 </select>
						<?php endif;?>
				      </div>

 					
				      <fieldset class="field">

						  <div class="field">
						  	<label>Note</label>
						   	<textarea name="note"  rows="4" cols="50"></textarea>
						  </div>
				      </fieldset>
				      <button class="ui button primary" type="submit">Request Product</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
