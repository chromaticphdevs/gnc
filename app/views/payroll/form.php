<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form method="post" action="/payroll/login">
		<h3><?php echo $title;?></h3>

		<input type="text" name="password">
		<div>
			<small><?php echo $message;?></small>
		</div>
		<input type="submit" name="" value="Login">
	</form>
</body>
</html>