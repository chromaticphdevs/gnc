<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			width: 500px;
			margin:0px auto;
			word-wrap: break-word;
		}
	</style>
</head>
<body>

	<h1>Login success</h1>

	<ul>
		<li>DB ID : <?php echo $id?></li>
		<li>AGENT : <?php echo $secret->Agent?></li>
		<li>UNIQID : <?php echo $secret->UNIQUEID?></li>

		<div>
			Secret Stored in DB : 
			<p>
				<?php echo $your_secret?>
			</p>
		</div>
	</ul>
</body>
</html>