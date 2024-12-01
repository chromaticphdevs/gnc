<div class="four wide column">
  <div class="ui secondary vertical menu">

  	<?php if(Session::get('user')['type']=="admin" || Session::get('user')['type']== "super admin"):?>
	  <div>
	  	 <a class="active item" href="/LDUser/profile">
		    <center> <h4><strong><font  color="blue"><u>Profile</u></font></strong></h4></center>
		  </a>


		 	 <?php if(Session::get('user')['type']== "super admin"):?>
				  <a class="active item">
				    <center> <h4><strong>Accounts</strong></h4></center>
				  </a>
				  <a class="item" href="/LDUser/create_account">Create User</a>
				  <a class="active item">
				    <center> <h4><strong>Branch</strong></h4></center>
				  </a>
				  <a class="item" href="/LDBranch/create">Create Branch</a>
			 <?php endif;?>


		  <a class="active item">
		    <center> <h4><strong>Classes</strong></h4></center>
		  </a>
		  <a class="item" href="/LDClass/create">Create</a>
		  <a class="item" href="/LDClass/list">List</a>
	  </div>

	  <div>
		  <a class="active item">
		    <center> <h4><strong>Lenders</strong></h4></center>
		  </a>
		  <a class="item" href="/LDUser/create">Create</a>
		  <a class="item" href="/LDUser/list">List</a>
	  </div>
	

		<?php if(Session::get('user')['type']== "super admin"):?>
			  <div>
				  <a class="active item">
				    <center> <h4><strong>Loans</strong> </h4></center>
				  </a>
				  <p class="item">Cash Advance</p>
				  		<ul>
		  					<li><a class="item" href="/LDCashAdvance/create">Create</a></li>
		  					<li><a class="item" href="/LDCashAdvance/list">list</a></li>
						</ul>  
				  <p class="item">Product Advance</p>
				  		<ul>
		  					<li><a class="item" href="/LDProductAdvance/create">Create</a></li>
		  					<li><a class="item" href="/LDProductAdvance/list">list</a></li>
						</ul>  
			  </div>
		<?php endif;?>	

	   <div>
		  <a class="active item" href="/LDUser/logout">
		    <center> <h4><strong><font  color="red"><u>Logout</u></font></strong></h4></center>
		  </a>
		   
	  </div>
	<?php elseif(Session::get('user')['type']=="customer"):?>

	  <div>
	  	  <a class="active item" href="/LDUser/profile">
		    <center> <h4><strong><font  color="blue"><u>Profile</u></font></strong></h4></center>
		  </a>
	  </div>
	  

	   <div>
		  <a class="active item" href="/LDUser/logout">
		    <center> <h4><strong><font  color="red"><u>Logout</u></font></strong></h4></center>
		  </a>
		   
	  </div>

	<?php endif;?>
	</div>
</div>