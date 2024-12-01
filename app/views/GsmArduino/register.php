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

			

							<form method="post" action="#" onSubmit = "return input_submit()" autocomplete="off">

								<h3><?php Flash::show();?></h3>
								<span class="login100-form-title p-b-55">
									Test <br> Arduino GSM
								</span>
					

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Cell Phone Number is required">
									<input class="input100" type="number" name="cp_number" id="cp_number" placeholder="Cell Phone Number" required>

									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-phone-handset"></span>
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

	
	<!--       ))))))))))))))))))))))))))))Confirmation modal(((((((((((((((( -->
<div class="modal fade" id="modalForm_text" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Confirmation</h4>
      
      </div>
      <div class="modal-body mx-3">


     	<center><h4>We have sent a code to your mobile number Please Enter code to confirm your registration</h4></center><br><br>
		<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
			<input size="20" maxlength="20" style="text-transform:uppercase" class="input100" type="text" autocomplete="off" name="confirm_code" id="confirm_code_text" placeholder="Code" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<span class="lnr lnr-checkmark-circle"></span>
			</span>
		</div>

		<input size="20" maxlength="20" style="text-transform:uppercase"  type="hidden" autocomplete="off" name="codecode" id="codecode_text" placeholder="Code" required>


      </div>

      <div id = "text_code_confirm">
	      <div class="modal-footer d-flex justify-content-center" >
	        <button class="login100-form-btn" onclick="register_user()" >Confirm</button>
	      </div>
      </div>

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
	<script> 

		var username;

		function input_submit()
		{	
	

			var cp_number =$("#cp_number").val();


			if(/^[0-9]+$/i.test(cp_number)==true)
			{
			  	if(cp_number.length<=10 || cp_number.length>=12)
			  	{
			      
			        alert("Invalid Number. Please Enter 11 digit number"); 
			        document.getElementById("cp_number").focus();
					return false;

				}else{

				    if(cp_number.substring(0, 2)!="09")
				    {
				         
					    alert("Invalid Number format eg. 09*********"); 
					    document.getElementById("cp_number").value = "";
					    document.getElementById("cp_number").focus();
						return false; 
				      
					}
				}
			}
			else
			{ 
				alert("Please Enter Number Only for Contact Number"); 
				document.getElementById("cp_number").value = "";
			    document.getElementById("cp_number").focus();
				return false; 
			}

			$.ajax({
		      method: "POST",
		      url: '/GsmArduino/gsm_sms_test',
		      data:{
		      	cp_number: cp_number
		  		},
		      success:function(response)
		      {
		        console.log(response);
	      		document.getElementById("codecode_text").value = response.trim();
	      		
	      		$('#modalForm_text').modal({
				    backdrop: 'static',
				    keyboard: false
				})


		      }
			});	

			return false;
		}	


		function register_user()
		{	
			
			var code = $("#codecode_text").val();
			var user_input = $("#confirm_code_text").val();
			
		
			user_input = user_input.toUpperCase();

			if(code != user_input)
			{
				
				alert("Invalid Code");
	
				
			}else{
				//$("#text_code_confirm").hide(3000);
				 document.getElementById("text_code_confirm").style.visibility = "hidden";

				 alert("Code is Valid");
				 window.location = get_url("/GsmArduino/gsm_sms_test");
				      


			}


		}

		$(document).ready(function() {
  				  $('input100').select2();

		});
	</script>
</body>
</html>