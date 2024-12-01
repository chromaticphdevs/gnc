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
			<div class="seven wide column">
				<section class="ui segment">
        		 <?php Flash::show('msg');?>
				<h3>Use Token</h3>
				<div class="ui segment">
					<form class="ui form" method="post">
						<div class="filed">
							<label for="#">Token Code</label>
							<input type="text" name="token" value="<?php echo $_POST['token'] ?? ''?>">
						</div>
						<br>
						<input type="submit" value="Create Tokens">
				    </form>
				</div>
				</section>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
