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
				<h3>Product Advance</h3>
				<div class="ui segment">
					<form class="ui form">
				      <div class="field">
				      	 <label>&nbsp;&nbsp;&nbsp;&nbsp;
				      	 	<a href="/LDCashAdvance/payment_back_camera/<?php echo $userinfo->id ?>">| Back Camera |</a>
				      	 </label>
				      	 <img src="" id="image">
     					<input type="hidden" name="send_image" id="send_image">
				      	<canvas style="display: none" width="200px" height="200" ></canvas>
   				        <video id="video"  autoplay muted></video>
				        <label>Lenders Name</label>

							<input type="hidden" name="userId" id="userId" class="form-control" 
							value="<?php echo $userinfo->id; ?>" readonly>

							<input type="text" name="username" class="form-control" 
							value="<?php echo $userinfo->firstname.' '.$userinfo->lastname; ?>" required >
							<br>
							
						<table class="ui celled table">
									<thead>
										<th>Cash Loan ID</th>
										<th>Amount</th>
										<th>Payments</th>
										<th>Balance</th>
										<th>Date</th>
										<th>Principal</th>
                   						 <th>Interest</th>
                   						  <th>Total</th>
									</thead>
									<tbody>
									
										  <?php $total_payment=0; ?>
						                    <?php foreach($loan_info_list_cash as $info_list) : ?>
						                      
						                      <tr>
						                        <td><?php echo $info_list->id?></td>
						                        <td><?php echo $info_list->amount?></td>
						                        <td></td>
						                         <td></td>
						                        <td><?php echo $info_list->date?></td>
						                        <td><?php echo $principal=$info_list->amount/25; ?></td>
						                        <td><?php echo $interest=($info_list->amount*0.05)/4; ?></td>
						                        <?php $total=$interest+$principal; ?>
						                        <td><input type="number" name="amount"  id="cashAdvance" value="<?php echo $total; ?>" class="form-control" required></td>
						                        <?php $total_payment=$total_payment+ $total;?>
						                      </tr>
						                    <?php endforeach;?>
						                    <tr>    
						                      <td></td>    
						                      <td>Total:&nbsp;<b><?php echo $cashAdvance_balance->balance ?></b></td>
						                      <td></td>
						                       <td></td>
						                      <td></td>
						                      <td></td>
						                      <td></td>
						                      <td><?php echo $total_payment; ?></td>
						                  			
											</tr>
									</tbody>
								</table>
							<br>
						      <!--<label>Cash Advance Amount</label><br>-->
						      	<?php
								$interest=($cashAdvance_balance->balance*0.05)/4;
								$principal=$cashAdvance_balance->balance/25;
								$total=$interest+$cashAdvance_balance->balance/25;
							//	echo "Principal: <b>".$principal.="</b> + Interest: <b>".$interest."</b>";
								?>
							
								 <table class="ui celled table">
					                  <thead>
					                    <th>Product Loan ID</th>
					                    <th>Amount</th>
					                    <th>Payments</th>
					                    <th>Balance</th>
					                    <th>Date</th>
					                      <th>Total</th>
					                  </thead>
					                  <tbody>
					                        <?php 
					                        $total_TB_pay=0;
					                        $total_product=0;
					                        ?>
					                    <?php foreach($loan_info_list_product as $info_list_product) : ?>
					                      
					                      <tr>
					                        <td><?php echo $info_list_product->id?></td>
					                        <td><?php echo $info_list_product->amount?></td>
					                        <td></td>
					                        <td></td>
					                        <td><?php echo $info_list_product->date?></td>
					                        <?php $total_product=$total_product+$info_list_product->amount; ?>
					                       <td><input type="number" name="amount"  id="cashAdvance" value="<?php echo $info_list_product->amount/4; ?>" class="form-control" required></td>
					                      </tr>
					                      <?php $total_TB_pay=$total_TB_pay+($info_list_product->amount/4);?>
					                    <?php endforeach;?>
					                    <tr>
					                        <td></td>
					                        <td>Total:&nbsp;<b><?php echo $total_product ?></b></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td><?php echo $total_TB_pay; ?></td>
					                    </tr>
					                  </tbody>
					                </table>
							<br>

							
				      </div>
 					
				      <fieldset class="field">
				     
						  <div class="field">
						  	<label>Note</label>
						   	<textarea name="note" id="note" rows="4" cols="50" required></textarea>
						  </div>
				      </fieldset>
				      <button class="ui button primary" id="btnpayment" >Send Payment</button>
				    </form>
				</div>
			</div>
		</div>
		
	</main>

	<script type="text/javascript" defer>
  $( document ).ready(function(){

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
  });

  function timeIn()
  {

    const canvas = document.querySelector('canvas');
    const image = document.querySelector('#image');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    image.src = canvas.toDataURL('image/png');

    $("#send_image").val(canvas.toDataURL('image/png'));

    $.ajax({
      method: "POST",
      url: get_url('/LDCashAdvance/send_payment'),
      data:{
      	userId: $("#userId").val() , 
      	cashAdvance : $("#cashAdvance").val() , 
      	productAdvance : $("#productAdvance").val() ,
      	 note : $("#note").val() ,
      	 image:$("#send_image").val()},

      success:function(response)
      {

      	 console.log(response);
        // let returnData = JSON.parse(response);
      
        if(response == '1')
        {
          window.location = get_url('LDUser/profile');
        }else{
          console.log(response);
          // alert("ERROR");
        }
      }
    });
    // login($("#to_send_image").val());
  }
  </script>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
