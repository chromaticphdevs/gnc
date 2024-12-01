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
				<section class="ui segment">
        		 <?php Flash::show();?>
				<h3>Create Class</h3>
				<div class="ui segment">
					<form class="ui form" method="post">
						<div class="filed">
							<label for="#">Numbe of tokens</label>
							<input type="number" name="tokenCount">
						</div>
						<br>
						<input type="submit" value="Create Tokens">
				    </form>
				    <hr>
				    <section>
				    	<h3>List of tokens</h3>
				    	<table class="table">
				    		<thead>
				    			<th>#</th>
				    			<th>Code</th>
				    			<th>Used</th>
				    			<th>Created_at</th>
				    		</thead>

				    		<tbody>
				    			<?php foreach($tokenList as $key => $row) :?>
				    				<tr>
				    					<td><?php echo ++$key?></td>
				    					<td><?php echo $row->code?></td>
				    					<td><?php echo $row->is_used == 1 ? 'Used' : 'Un-used'?></td>
				    					<td><?php echo $row->created_at?></td>
				    				</tr>
				    			<?php endforeach;?>
				    		</tbody>
				    	</table>
				    </section>
				</div>
			</div>
		</div>
		
	</main>
	
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
