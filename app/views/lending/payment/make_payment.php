<?php require_once VIEWS.DS.'lending/template/header.php'?>
<style type="text/css">
	input[type='text']{
		width: 70px;
	}


table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1.5px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}



</style>
</head>
<body>
	<main class="ui container">

		 <div class="ui inverted menu">
		  <a class="item" href="/LDUser/logout">
		    LOGOUT
		  </a>
		  &nbsp;
		  <?php if(Session::get('user')['type']=="cashier"):?>
			   <a class="item" href="/LDCashier/index">
				  BACK
			   </a> 
		   <?php else:?>

			   	 <a class="item">
				   <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
			
			   </a> 
			<?php endif;?>


		</div>
		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>

			<div class="twelve wide column">
				<!-- CAMERA -->
				<input type="hidden" name="userid" value="<?php echo $userid?>">
				<section class="ui segment">
			      	<img src="" id="image">

					<input type="hidden" name="send_image" id="send_image">

			      	<canvas style="display: none" width="200px" height="200" ></canvas>

				    <video id="video"  autoplay muted></video>
				</section>
				<?php $grand_total=0; ?>
		
				<!-- // CAMERA -->
				<section class="ui segment">
					<h3 class="#">Cash Advance Payment</h3>
					<?php $cashLoans = $data['loans']['cash'] ?>
					<?php $cashTotal = 0?>

				<div style="overflow-x:auto;">
					<table class="table">
						<thead>
							<th>Loan Id</th>
							<th>Amount</th>
							<th>Payments</th>
							<th>Balance</th>
							<th>Date</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>Total</th>
						</thead>	

						<tbody>
							<?php foreach($cashLoans as $key => $cashLoan) :?>
								<?php $cashTotal += $cashLoan->get_total()?>
								<?php $payment = $cashLoan->total_payment - $cashLoan->interest_total;?>
							
								<?php $balance = $cashLoan->amount - $payment ?>
								<?php if($balance != 0):?>
								<tr>
									<td>
										<input type="text" name="cash_loanid" 
											value="<?php echo $cashLoan->id?>" readonly>
									</td>
									<td><?php echo $cashLoan->amount?></td>
								<td><?php echo $payment < 0 ? 0: $payment?></td>

									<td><?php echo $balance?></td>
									<td><?php echo $cashLoan->date?></td>
									<td>
										<input type="text" name="cash_principal" 
											value="<?php echo $cashLoan->get_principal()?>">
									</td>
									<td>
										<input type="text" name="cash_interest" 
											value="<?php echo $cashLoan->get_interest()?>">
									</td>
									<td>
										<input type="text" name="cash_total" 
											value="<?php echo $cashLoan->get_total()?>">

											<?php $grand_total=$grand_total+$cashLoan->get_total(); ?>
									</td>
								</tr>

							<?php endif; ?>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				</section>


				<section class="ui segment">
					<h3 class="#">Product Advance Payment</h3>
					<?php $productLoans = $data['loans']['product'] ?>
					<?php $productTotal = 0;?>
				 <div style="overflow-x:auto;">
					<table class="table">
						<thead>
							<th>Loan Id</th>
							<th>Amount</th>
							<th>Payments</th>
							<th>Balance</th>
							<th>Date</th>
							<th>Total</th>
						</thead>

						<tbody>
							<?php foreach($productLoans as $productLoan) :?>
								<?php $productTotal += ($productLoan->amount / 4);?>
						
							<?php if($productLoan->get_balance() != 0):?>
								<tr>
									<td><input type="text" name="product_loanid" 
											value="<?php echo $productLoan->id?>" readonly>
									</td>
									<td>
										<input type="text" value="<?php echo $productLoan->amount?>" readonly>
									</td>
									<td><?php echo $productLoan->total_payment?></td>
									<td><?php echo $productLoan->get_balance()?></td>
									<td><?php echo $productLoan->date?></td>
									<td>
										<input type="text" name="product_amount" 
											value="<?php echo $productLoan->amount / 4?>">
											<?php $grand_total=$grand_total+($productLoan->amount / 4); ?>
									</td>
								</tr>
							<?php endif; ?>
							<?php endforeach?>
						</tbody>
					</table>
				</div>
					<div>
						<h3>Grand Total : <?php echo number_format($grand_total , 2) ?></h3>
					</div>
							<br>
						
						  	<h3>Note</h3>
						   	<textarea name="note"  id="note" rows="4" cols="50"></textarea>
					
				</section>
				

				<form method="post">
					<input type="submit" name="" class="btn btn-primary" value="Make Payment">
				</form>
			</div>
		</div>
		 <input type="hidden" id="user_type" name="user_type" value="<?php echo Session::get('user')['type']; ?>">
	</main>
	<script type="text/javascript" defer>
	  $( document ).ready(function()
	  {

	  	activateCamera();

	  	$("form").submit(function(evt)
	  	{
	  		let image = getImage();

	  		let cashPayments = $(`input[name *= 'cash']`);

	  		let productPayments = $("input[name *='product']");

	  		console.log($("#note").val());
	  		
	  		let payments = {
	  			cash : {
	  				loanid: [] ,
	  				interest: [] ,
	  				principal : [],
	  				total :[]
	  			},


	  			product: {
	  				loanid : [],
	  				total : []
	  			},

	  	
	  			payerid: $("input[name='userid']").val() ,

	  			note: $("#note").val(),
	  		};

	  		$.each(cashPayments , function(index , input) {

	  			if(input.name == 'cash_loanid') {
	  				payments.cash.loanid.push(input.value);
	  			}

	  			if(input.name == 'cash_principal') {
	  				payments.cash.principal.push(input.value);
	  			}

	  			if(input.name == 'cash_interest') {
	  				payments.cash.interest.push(input.value);
	  			}

	  			if(input.name == 'cash_total') {
	  				payments.cash.total.push(input.value);
	  			}
	  		});

	  		$.each(productPayments , function(index , input) {

	  			if(input.name == 'product_loanid') {
	  				payments.product.loanid.push(input.value);
	  			}

	  			if(input.name == 'product_amount') {
	  				payments.product.total.push(input.value);
	  			}
	  		});

	  		var user_type=$("#user_type").val();

	  		$.ajax({
	  			url:get_url('LDPayment/do_payment'),
	  			method:'post',
	  			data:{ 
	  				payments : JSON.stringify(payments),
	  				image : image
	  			},
	  			success:function(result) {

	  				if(result == 'success'){
	  					if(user_type=="cashier"){
							window.location = get_url('/LDCashier/index');
	  					}else{
	  						window.location = get_url('LDUser/profile');
	  					}
	  					
	  				
	  				}else{

	  					console.log(result);

	  				}
	  			}
	  		});
	  		evt.preventDefault();
	  	});

	  });


	  function activateCamera()
	  {
	  		const video = document.querySelector('video');

	      const btnLogin = document.querySelector("#btnpayment");

		      
	      const constraint = {

	          video : true
	      };

	      navigator.mediaDevices.getUserMedia(constraint).then((stream) => {video.srcObject = stream});

	      $("#btnpayment").click(function(evt)
	      {
	        timeIn();

	        evt.preventDefault();
	      });
	  }


	  function getImage()
	  {
	  	const canvas = document.querySelector('canvas');
    	const image = document.querySelector('#image');

    	canvas.width = video.videoWidth;
	    canvas.height = video.videoHeight;
	    canvas.getContext('2d').drawImage(video, 0, 0);

	    image.src = canvas.toDataURL('image/png');

    	$("#send_image").val(canvas.toDataURL('image/png'));


    	return $("#send_image").val();
	  }
  </script>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
