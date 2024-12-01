<!DOCTYPE html>
<html lang="en">
<head>
	<meta property="og:image" content="<?php echo URL.DS?>uploads/money_money.png"/>
    <meta property="og:type" content="image/jpeg"/>
    <meta property="og:width" content="300"/>
    <meta property="og:height" content="300"/>
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
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/select2/select2.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/form/util.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/form/main.css'?>">
	<script type="text/javascript" src="<?php echo URL.DS.'js/core/conf.js'?>"></script>
<!--===============================================================================================-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
<!--===============================================================================================-->

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">


							<form method="post" action="/AccountProfile/add_heir"  autocomplete="off">

								<h3><?php Flash::show();?></h3>
								<span class="login100-form-title p-b-55">
									 Heir Fullname
								</span>
						
						

								<!-- --------------------Address Info-->

								<input type="hidden" value="<?php echo $_GET['user']; ?>" name='userid'>


								<div class="wrap-input100 validate-input m-b-16" data-validate = "First Name is required">
									<input class="input100" type="text" autocomplete="off" name="firstname"  placeholder="First Name" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Middle Name is required">
									<input class="input100" type="text" autocomplete="off" name="middlename"  placeholder="Middle Name" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Last Name is required">
									<input class="input100" type="text" autocomplete="off" name="lastname"  placeholder="Last Name" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>


								<div class="container-login100-form-btn p-t-25">
									<button class="login100-form-btn">
										Submit
									</button>
								</div>


								<div class="text-center w-full p-t-42 p-b-22">
									<div class="login100-pic js-tilt" data-tilt>
											<img src="<?php echo URL.DS.'uploads/breakthrough.jpg'?>" width="100%" height="230px" alt="IMG">
									</div><br>
										
									</div>

					
							</form>
		
			</div>
		</div>
	</div>

	

		
<!--===============================================================================================-->	
	<script src="<?php echo URL.DS.'vendors/form/jquery/jquery-3.2.1.min.js'?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo URL.DS.'vendors/form/bootstrap/js/popper.js'?>"></script>
	<script src="<?php echo URL.DS.'vendors/form/bootstrap/js/bootstrap.min.js'?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo URL.DS.'vendors/form/select2/select2.min.js'?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo URL.DS.'vendors/form/tilt/tilt.jquery.min.js'?>"></script>
	<script src="<?php echo URL.DS.'js/form/main.js'?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	
</body>
</html>