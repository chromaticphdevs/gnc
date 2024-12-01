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
				<h3>Change Class</h3>
				<div class="ui segment">
					<form class="ui form" method="POST" action="/LDClass/update_user_class">
				      <div class="field">
				        <label>Class Name</label>
				          <select name="newgroup" required >
				          	<option value="">-Select Class</option>
				          	<?php foreach($classList as $className): ?>
				          		<!-- 
				          		<?php $selected = $_GET['groupId'] == $className->id ? 'selected' : ''?> -->

				          		<?php if($className->id ==  $_GET['groupId']) {continue;}?>
						    	<option  value="<?=$className->id?>" <?php echo $selected?>> <?=$className->name?></option>

						    <?php endforeach; ?>
						  </select>
				      </div>
				      <input type="hidden" name="userId" value="<?= $_GET['userId']?>" >
				       <input type="hidden" name="prevgroup" value="<?= $_GET['groupId']?>" >
				      <fieldset class="field">
				      	<legend>Note</legend>
					      <div class="two fields">
						 
							<textarea name="note"  rows="4" cols="50"></textarea>
						  </div>

				      </fieldset>
				      <button class="ui button primary" type="submit">Save</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
