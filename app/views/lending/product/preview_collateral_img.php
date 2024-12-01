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
		   <a class="item"  href="/LDUser/profile"> 
		 <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
		  </a>
	     <a class="item"  href="/LDUser/profile">
	 			&nbsp; &nbsp;Back
		 </a>
		</div>	
 		
		   


				<div class="ui segment">
			
					<a class="btn btn-primary btn-sm" href="/LDProductAdvance/upload_collateral/?loanID=<?php echo $loanId;?>">Upload<br>Collateral Image</a>
				</div>

				<div class="ui segment">
				
					<h3>Collateral Images</h3>
						<?php if(empty($collateral_img_list)): ?>
							<strong>No Result</strong>
						<?php else: ?>	
					<table class="ui celled table">

				       <tbody>
					    
						    <?php foreach($collateral_img_list as $data): ?>
						      
						          <td data-label="Prev"><img src="<?php echo URL.DS.'assets/collateral/'.$data->image?>"></td>

					      	<?php endforeach;?>
					       
				       </tbody>
				    </table>
				    <?php endif;?>	
						
				</div>
	
	</main>
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
