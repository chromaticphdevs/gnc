<?php include_once VIEWS.DS.'templates/market/header.php'?>
<style type="text/css">
	.item_details{
		padding: 10px;
		border-bottom: 1px solid #000;
	}
	.item_details img
	{
		width:100%;
	}
</style>
</head>
<body>
	<?php include_once VIEWS.DS.'templates/market/navigation.php'?>  <br>  <br>  <br>
	  <section class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(<?php echo URL.'/assets/'; ?>/overlay-bg.jpg)">
   
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="home" class="box-shadow-full">
		<div class="row">
			<div class="col-md-5 content-container">
				<?php Flash::show();?>
				<hr>
				<h3>Cart Item</h3>
				<div class="item_details">
					<img src="<?php echo URL.DS.'assets/'.$cartItem->p_image?>">
				</div>
				<div class="item_details"> - Product : <?php echo $cartItem->p_name?> </div>
				<div class="item_details"> - Price : <?php echo $cartItem->p_price?></div>
				<div class="item_details"> - Quantity : 
					<form method="post" action="/cartItem/updateQuantity">
						<input type="hidden" name="itemid" value="<?php echo $cartItem->id?>">
						<div class="row">
							<div class="form-group col-md-7">
								<input type="number" name="quantity" class="form-control" value="<?php echo $cartItem->ci_quantity?>">
							</div>

							<div class="form-group col-md-3">
								<input type="submit" name="" class="btn btn-success" value="Update">
							</div>
						</div>					
					</form>
				</div>
				<div class="item_details"> 
					<h3>
						Total :<?php echo $cartItem->total_price?> 
					</h3>
				</div>
			</div>

			<div class="col-md-5 content-container">
				<form method="post" action="/billing/checkout" enctype="multipart/form-data">
					<hr>
		            <fieldset>
		            	<div class="form-group">
		            		<label>Payment Attachment</label>
		            		<input type="file" name="payment_attachment" class="form-control">
		            		<small>Picture / Screen shot of your payment.</small>
		            	</div>
		                <div class="form-group">
		                    <label>Amount to pay <sup>*</sup></label>
		                    <input type="text" name="" class="form-control" 
		                    value="<?php echo $cartItem->total_price?>" readonly>
		                </div>
		                <div class="form-group">
		                    <label>Receiver fullname <sup>*</sup></label>
		                    <input type="text" name="fullname" class="form-control" 
		                    value="<?php echo $user->firstname . ' ' . $user->lastname?>">
		                </div>
		                <div class="form-group">
		                    <label> Receiver Mobile<sup>*</sup></label>
		                    <input type="text" name="mobile" class="form-control" 
		                    value="<?php echo $_POST['mobile'] ?? ''?>">
		                </div> 
		                <div class="form-group">
		                    <label>Receiver Email<sup>*</sup></label>
		                    <input type="text" name="email" class="form-control" 
		                    value="<?php echo $user->email?>">
		                </div>
		                <fieldset>
		                	<legend>Shipping Address</legend>

		                	<div class="form-group">
		                		<label>House#<sup>*</sup></label>
		                		<input type="text" name="home" class="form-control">
		                		<small>If no house # put your area</small>
		                	</div>

		                	<div class="form-group">
		                		<label>Street <sup>*</sup></label>
		                		<input type="text" name="street" class="form-control" required>
		                	</div>

		                	<div class="form-group">
		                		<label>Barangay <sup>*</sup></label>
		                		<input type="text" name="barangay" class="form-control" required>
		                	</div>

		                	<div class="form-group">
		                		<label>City/Province <sup>*</sup></label>
		                		<input type="text" name="city" class="form-control" required>
		                	</div>
		                </fieldset>
		            </fieldset>
		            <input type="submit" name="" class="btn btn-primary" value="Purchase" id="purchase">
		            <br>  <br>  <br>
		        </form>
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
	</section>

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
	<script type="text/javascript">
			
		$( document ).ready(function()
		{
			$("#purchase").click(function(evt)
			{
				if(!confirm('Click ok to confirm your puchase')){
					evt.preventDefault();
				}
			});
		});

	</script>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>