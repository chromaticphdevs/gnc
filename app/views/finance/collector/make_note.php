<?php build('content')?>
 <div style="overflow-x:auto;">
	<h3>Payment</h3>
	<table class="table">
	   <tr>
	    <td>Loan #:</td>
	    <td><strong><?php echo $result->code; ?></strong></td>
	  </tr>
	  <tr>
	    <td>Fullname:</td>
	    <td><strong><?php echo $result->fullname; ?></strong></td>
	  </tr>
	  <tr>
	    <td>Email:</td>
	    <td><strong><?php echo $result->email; ?></strong></td>
	  </tr>
	  <tr>
	    <td>Mobile Number:</td>
	    <td><strong><?php echo $result->mobile; ?></strong></td>
	  </tr>
	   <tr>
	    <td>Package Name:</td>
	    <td><strong><?php echo $result->package?></strong></td>
	  </tr>
	   <tr>
	    <td>Product Amount:</td>
	    <td><strong>&#8369;  <?php echo $result->amount?></strong></td>
	  </tr>
	   <tr>
	    <td>Delivery Fee:</td>
	    <td><strong>&#8369;  <?php echo $result->delivery_fee?> </strong></td>
	  </tr>
	</table>

	<div>

		<table class="table">
			<tr>
				<td>Make Note</td>
				<td>
				   <form action="/FNProductBorrower/make_notes" method="post" enctype="multipart/form-data">
                        <input type="text" name="note" class="form-control" required>
						<input type="hidden" name="loanid" class="form-control" value="<?php echo $result->id?>">
						<input type="hidden" name="userid" class="form-control" value="<?php echo $userid?>">
						<br>
                        <input type="submit"  value="Submit Note" class="btn btn-success btn-sm" id='make_note'>
                   </form>
				</td>
			</tr>
		</tab	le>
		       
	<h3>All Notes</h3>
	    <table class="table">
	        <thead>
	            <th>#</th>
	            <th>Notes</th>
	            <th></th>
	        </thead>

	         <tbody>
	               <?php $counter = 1;?>
	               <?php foreach($all_notes as $data) :?>
	                  <tr>
	                        <td><?php echo $counter ?></td>
	                        <td><b><h4><?php echo $data->note; ?></h4></b></td>
	                        <td><b><h5><?php
				                  $date=date_create($data->created_at);
				                  echo date_format($date,"M d, Y");
				                  $time=date_create($data->created_at);
				                  echo date_format($time," h:i A");
				                ?>
				            </h5></b></td>  
	                  </tr>
	                <?php $counter++;?>
	                <?php endforeach;?>
	        </tbody>
	    </table>
	</div>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>