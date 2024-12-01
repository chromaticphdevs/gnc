<!DOCTYPE html>
<html lang="en">
<head>
	<title>Breakthrough Pre-Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo URL.DS.'uploads/main_icon.png'?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/bootstrap/css/bootstrap.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'fonts/font-awesome-4.7.0/css/font-awesome.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'fonts/Linearicons-Free-v1.0.0/icon-font.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/animate/animate.css'?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/css-hamburgers/hamburgers.min.css'?>">
<script type="text/javascript" src="<?php echo URL.DS.'js/core/conf.js'?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
<!--===============================================================================================-->
<?php produce('headers')?>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Navigations</h4>
					</div>

					<div class="card-body">
						<ul>
							<li><a href="/CodeBatchController/">Batch</a></li>
							<li><a href="/RaffleRegistrationController/index">Registered</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-8 mx-auto">
				<?php produce('content')?>
			</div>
		</div>
	</div>
    <script src="<?php echo URL.DS.'vendors/form/jquery/jquery-3.2.1.min.js'?>"></script>
    
    <?php produce('scripts')?>
</body>
</html>