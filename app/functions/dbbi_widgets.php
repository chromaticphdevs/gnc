<?php 	

	function ddbi_binary_branch($user = null)
	{
		if(!is_null($user->id)) 
		{
			?> 
			<a href="#">
	            <div class="circle#">
	               <img class="img-xs rounded-circle" 
	               src="http://www.dbbi-e.com/applications/ecommerce/public/assets/global/user-pres.png" alt="profile image"> 
	            </div>
	            <div>
	            	<?php echo $user->firstname . ' ' .$user->lastname?>
	                <div><?php echo $user->username?></div>
	            </div>
	        </a>
			<?php
		}
	}