<?php build('content') ?>
	<!---  --------------------------------------------cash advance--------------------------------------------------------->
	    <br>
	    <div style="overflow-x:auto;">
	    <h2><b>Cash Advance</b></h2>
	    <table class="table">
		        <thead>
		            <th>#</th>
		            <th>Loan Number</th>
		            <th>Date & Time</th>   
		            <th>Amount</th>
		            <th>Payment</th>
		            <th>Balance</th>
		            <th>Status</th>
		            <th></th>
		        </thead>

		         <tbody>
		               <?php $counter = 1;?>
		               <?php foreach ($cash_loan as $key => $value):?>
		                  <tr>
		                        <td><?php echo $counter ?></td>
		                        <td><a id="show_ca_payments">#<?php echo $value->code; ?></a></td>
		                        <td>
		                        <?php
		                            $date=date_create($value->date);
		                            echo date_format($date,"M d, Y");
		                            $time=date_create($value->time);
		                            echo date_format($time," h:i A");
		                          ?>
		                        </td>   
		                        <td><?php echo $value->amount; ?></td>
		                        
		                        <td>
		                        	<?php echo $value->payment; ?><br><br>
								   
		                        </td>

		                        <td><?php echo ($value->amount) - $value->payment; ?></td>

		                        <td>
		                              <?php if($value->status != "Paid" ):?>
		                                 <h4><b><span class="label label-info">NOT PAID</span></b></h4>
		                              <?php else:?>
		                                 <h4><b><span class="label label-success">PAID</span></b></h4>
		                              <?php endif;?>
		                        </td>
		                        <td style="text-align: center;">
                            <?php if($value->status != "Paid" ):?>
                              
                              <a class="btn btn-success btn-sm" href="/CAOnlinePayment/customer_payment/<?php echo seal($value->id)?>"> Make Payment</a>
                            <?php endif;?>
                          </td>
		                  </tr>
		                <?php $counter++;?>
		                <?php endforeach;?>
		        </tbody>
		    </table>
		<br>

 	<div id="ca_payment">

	 <table class="table">
	 	<h2><b>Cash Advance Payment</b></h2>
	    <thead>
            <th>#</th>
            <th>Date</th>							         
            <th>Amount</th>	
        </thead>
        <tbody>
        	<?php $counter2 = 1;?>
				<?php foreach ($cash_payment as $key => $value):?>
					 <tr>
	        	<td><?php echo $counter2 ?></td>
	        	<td><?php
                    $date=date_create($value->date_time);
                    echo date_format($date,"M d, Y");
                    $time=date_create($value->date_time);
                    echo date_format($time," h:i A");
                  ?>
                  	
                </td>
	        	<td><?php echo $value->amount; ?></td>
	        	 </tr>
	        <?php $counter2++;?>
			 <?php endforeach;?>
        </tbody>
    </table>

   </div>

    <br>
    <br>

	
	<h2><b>Product Advance</b></h2>
    <table class="table">
	        <thead>
	            <th>#</th>
	            <th>Loan Number</th>
	            <th>Date & Time</th>   
	            <th>Amount</th>
	            <th>Delivery Fee</th>
	            <th>Payment</th>
	            <th>Balance</th>
	            <th>Number of box</th>
	            <th>Status</th>
	            <th></th>
	        </thead>

	         <tbody>
	               <?php $counter = 1;?>
	               <?php foreach($loan_data as $data) :?>
	                  <tr>
	                        <td><?php echo $counter ?></td>
	                        <td><a id="show_product_payments">#<?php echo $data->code; ?></a></td>
	                        <td>
	                        <?php
	                            $date=date_create($data->date_time);
	                            echo date_format($date,"M d, Y");
	                            $time=date_create($data->date_time);
	                            echo date_format($time," h:i A");
	                          ?>
	                        </td>   
	                        <td><?php echo $data->amount; ?></td>
	                        <td><?php echo $data->delivery_fee; ?></td>
	                        <td><?php echo $data->payment; ?></td>
	                        <td><?php echo ($data->amount + $data->delivery_fee ?? 0) - $data->payment; ?></td>
	                        <td><?php echo $data->quantity; ?></td>
	                        <td>
	                              <?php if($data->status != "Paid" ):?>
	                                 <h4><b><span class="label label-info">NOT PAID</span></b></h4>
	                              <?php else:?>
	                                 <h4><b><span class="label label-success">PAID</span></b></h4>
	                              <?php endif;?>
	                        </td>
                          <td style="text-align: center;">
                            <?php if($data->status == "Approved" ):?>
                              
                              <a class="btn btn-success btn-sm" href="/OnlinePayment/show/<?php echo seal($data->id)?>"> Make Payment</a>
                            <?php endif;?>
                          </td>
	                  </tr>
	                <?php $counter++;?>
	                <?php endforeach;?>
	        </tbody>
	    </table>
  	<br>
	 <div id="product_payment">

	 <table class="table">
	 	<h2><b>Product Advance Payment</b></h2>
	    <thead>
            <th>#</th>
            <th>Date</th>							         
            <th>Amount</th>	
        </thead>
        <tbody>
        	<?php $counter2 = 1;?>
				<?php foreach ($product_payment as $key => $value):?>
					 <tr>
	        	<td><?php echo $counter2 ?></td>
	        	<td><?php
                    $date=date_create($value->date_time);
                    echo date_format($date,"M d, Y");
                    $time=date_create($value->date_time);
                    echo date_format($time," h:i A");
                  ?>
                  	
                </td>
	        	<td><?php echo $value->amount; ?></td>
	        	 </tr>
	        <?php $counter2++;?>
			 <?php endforeach;?>
        </tbody>
    </table>

   </div>
	    

	</div>

	<script type="text/javascript">
            
       
$( document ).ready(function() {

   $("#ca_payment").hide();
   $("#product_payment").hide();

   $("#show_ca_payments").on('click', function(event) 
   {
   
   	  var x = document.getElementById("ca_payment");
	  if (x.style.display === "none") {
	    x.style.display = "block";
	  } else {
	    x.style.display = "none";
	  }

   });

   $("#show_product_payments").on('click', function(event) 
   {
   	
   	  var x = document.getElementById("product_payment");
	  if (x.style.display === "none") {
	    x.style.display = "block";
	  } else {
	    x.style.display = "none";
	  }

   });

});

</script>
<?php endbuild()?>

<?php occupy('templates/layout')?>