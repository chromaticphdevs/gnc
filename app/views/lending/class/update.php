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
				<h3>Update Class</h3>
				<div class="ui segment">
					<form class="ui form"  method="post" action="/LDClass/updateInfo">
				      <div class="field">
				      	 <?php Flash::show();?>
				        <label>Class Name</label>
				        <input type="text" name="className" value="<?php echo $classInfo->name;?>" required>
				      </div>

				      <fieldset class="field">
				      	<legend>Schedule</legend>
					      <div class="two fields">
						    <div class="field">
						      <label>Day</label>
						      <select name="day">
						      	<?php for($i = 0; $i < 7 ;$i++) :?>
						      		<option value="<?php echo $i;?>"> <?php echo dayNumericToLong($i);?></option>
						      	<?php endfor;?>
						      </select>
						    </div>

						    <input type="hidden" name="classID" value="<?php echo $classInfo->id;?>">


						    <div class="field">
						      <label>Time</label>
						      <input type="time"  value="<?php $time = date("H:i", strtotime($classInfo->time)); echo "$time"; ?>" name="time" required>
						    </div>
						  </div>

						  <div class="field">
						  	<label>Repeat</label>
						    <select>
						    	<option>Every Week</option>
						    </select>
						  </div>
				      </fieldset>
				      <button class="ui button primary" type="submit">Update Class Info</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
