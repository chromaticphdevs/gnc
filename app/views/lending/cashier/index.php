<?php require_once VIEWS.DS.'lending/template/header.php'?>
<style type="text/css">
	table img
	{
		width: 100px;
	}
	.id-picture
	{
		width: 100%;
	}

	.my-users
	{
		padding: 10px;
		margin-bottom: 7px;

		background: #eee;
		color: #000;

		border:2px solid #000;
}
</style>
</head>
<body >

	<main class="ui container">
		<div class="ui inverted menu">
		  <a class="item" href="/LDUser/logout">
		    LOGOUT
		  </a>
		  &nbsp;
		   <a class="item">
		 <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
		  </a>
		 <a class="item">
		 &nbsp; &nbsp;<?php echo Session::get('user')['type'];?>
		  </a>

		     <a class="item" data-toggle="modal" data-target="#myModal">
						Purchase Package
			 </a>
			 
		  <a class="item" href="/LDUser/register">Register</a>	 
		</div>	

				<div class="ui segment">
				<?php Flash::show();?><br>
				<h2>Check Attendance</h2><br>

					<label>Search Customer:</label>
					<input type="text" class="form-control" name="username" id="username" onkeyup="search_data2()" >
					<div id="search_username">
				    </div>

				</div>

				<div class="ui segment">
				
					<h2>Make Payment</h2><br>
						<label>Search Customer:</label>
						<input type="text" class="form-control" name="refer_name" id="refer_name" onkeyup="search_data()" >
						<div id="search_data2">
					    </div>

				</div>


				<div class="ui segment">
				
				 <?php 
				 	$cash_total=0;
				 	$product_total=0;
				 	$total=0;
				 ?>


				 <?php foreach($cash_payments_today as $data): ?>
				 		<?php $cash_total+=$data->amount; ?>
				 <?php endforeach;?>
				 <?php foreach($product_payments_today as $data): ?>
				 		<?php $product_total+=$data->amount; ?>
				 <?php endforeach;?>

				 	<?php $total=$product_total+$cash_total; ?>

					<label>Total Cash Payments:&nbsp;&nbsp;P&nbsp;<?php echo to_number($cash_total);?></label><br>
					<label>Total Product Payments:&nbsp;&nbsp;P&nbsp;<?php echo to_number($product_total);?></label><br>
					<label>Grand Total:&nbsp;&nbsp;P&nbsp;<?php echo to_number($total);?></label>
						
				</div>
			

				<div class="ui segment">
					<h4>Cash Payment Vault</h4>
						<?php if(empty($cash_payments_today)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table id="table-data2" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Payer Name</th>
						        <th>Amount</th>
						        <th>Date & Time</th> 
					      </tr>
					  	</thead>
				       <tbody>
				      
				       <?php foreach($cash_payments_today as $data): ?>
				       	  <tr>
				          <td data-label="Prev"><?php echo $data->name?></td>
				          <td data-label="Next"><?php echo $data->amount?></td>
				          <td data-label="Date">
				          <?php
				          	 	$date=date_create($data->created_on);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($data->created_on);
                            	echo date_format($time," h:i A");
				          ?></td>
				         
				           </tr>
				      	<?php endforeach;?>
				       
				       </tbody>
				    </table>
				    <?php endif;?>	
				</div>

					<div class="ui segment">
					<h4>Product Payment Vault</h4>
						<?php if(empty($product_payments_today)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table id="table-data4" class="ui celled table">
					    <thead>
					       <tr>
					        	<th>Payer Name</th>
						        <th>Amount</th>
						        <th>Date & Time</th> 
					      </tr>
					  	</thead>
				       <tbody>
				      
				       <?php foreach($product_payments_today as $data): ?>
				       	  <tr>
				          <td data-label="Prev"><?php echo $data->name?></td>
				          <td data-label="Next"><?php echo $data->amount?></td>
				          <td data-label="Date">
				          <?php
				          	 	$date=date_create($data->created_on);
                            	echo date_format($date,"M d, Y");
                            	$time=date_create($data->created_on);
                            	echo date_format($time," h:i A");
				          ?></td>
				         
				           </tr>
				      	<?php endforeach;?>
				       
				       </tbody>
				    </table>
				    <?php endif;?>	
				</div>
	
	</main>



  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Purchase Package</h4>
        </div>
        <div class="modal-body">
 			    <div  id="select_lvl_activation">
	        		<center>
	        		
			        		<?php if($branch_activation_lvl!=null) :?>
						           <h2>Select Activation Level</h2>
						         	<select name="activation_lvl" id="activation_lvl"  class="form-control">
							
										       	<?php foreach($branch_activation_lvl  as $activation_levels) :?>
										       		
										       		<option value="<?php echo $activation_levels->activation_level;?>">
										   	   			<?php echo $activation_levels->activation_level; ?>
										      		</option>

										     	<?php endforeach;?>

									</select><br>

									<button class="btn btn-success" onclick="get_activation_code()">&nbsp;&nbsp;&nbsp;Purchase&nbsp;&nbsp;&nbsp;</button>

							<?php else: ?>	
								
								 <h2>No Activation Code</h2>

							<?php endif;?>

					
		            </center>
	            </div>

	            <div id="display_code">
		            	
		            <center>
			          <h2>Activation Code</h2>
			          <h2 id="purchase_code" style="color: red;"></h2><br>
			          <button class="btn btn-success" onclick="get_activation_code_reset()">&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;</button>

		            </center>

	            </div>
	        	


        </div>
        <div class="modal-footer">
         
        </div>
      </div>
      
    </div>
  </div>
 <!-- Modal -->

<?php require_once VIEWS.DS.'lending/template/footer.php'?>

	<script> 

		$(document).ready(function()
		{
			 $("#display_code").hide();
			/*event delegation*/

			$("#search_data2").on('click' , function(evt) {

				let target = evt.target;

				if(target.classList.contains('my-users')) {

					let my_id = target.dataset.id;

								  window.location=get_url("LDUser/preview/"+my_id);		
				}

			});


				$("#search_username").on('click' , function(evt) {

				let target = evt.target;

				if(target.classList.contains('my-users')) {

					let my_username = target.dataset.username;

								  window.location=get_url("LDUser/manual_login_cashier/"+my_username);		
				}

			});

		});

		function search_data(){
		   if($("#refer_name").val()!=""){

			  $.ajax({
		      method: "POST",
		      url: '/LDUser/live_search',
		      data:{data: $("#refer_name").val()},
		      success:function(response)
			      {

			      	reponse = JSON.parse(response);

			      	let html = ``;

			      	$.each(reponse , function(index , value) {

			      		html += `<div data-id='${value.id}' class='my-users'> ${value.fullname} </div>`;

			      	});
			      	
			        
			        $('#search_data2').html(html);
			        return false;			
			      }
			   });
			}else{
				 $('#search_data2').html("<div></div>");	
			}
		}



		function search_data2(){
		   if($("#username").val()!=""){

			  $.ajax({
		      method: "POST",
		      url: '/LDUser/live_search',
		      data:{data: $("#username").val()},
		      success:function(response)
			      {

			      	reponse = JSON.parse(response);
			      	console.log(reponse);
			      	let html = ``;

			      	$.each(reponse , function(index , value) {

			      		html += `<div data-username='${value.email}' class='my-users'> ${value.fullname} </div>`;

			      	});
			      	
			        
			        $('#search_username').html(html);
			        return false;			
			      }
			   });
			}else{
				 $('#search_username').html("<div></div>");	
			}
		}

			function get_activation_code(){

		
			 if(confirm("Confirm Purchase?")){



					$.ajax({
				      method: "POST",
				      url: '/LDActivation/purchase_code_branch',
				      data:{data: $("#activation_lvl").val()},
				      success:function(response)
				      {

				      	 console.log(response);
				      	 $('#purchase_code').html(response);
				         $("#select_lvl_activation").hide();
						 $("#display_code").show();
				       
				
				      }
					});	

			 }
		}

		function get_activation_code_reset(){

	      	 $('#purchase_code').html("");
	         $("#display_code").hide();
			 $("#select_lvl_activation").show();

		}
 			

 			
	</script>