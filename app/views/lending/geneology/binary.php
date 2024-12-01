<?php require_once VIEWS.DS.'lending/template/header.php'?>
<?php require_once FNCTNS.DS.'dbbi_widgets.php'?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/geneology.css'?>">
</head>
<body style="">
	<main class="ui container">
		<div class="ui inverted menu">
		  <a class="item" href="/LDUser/logout">
		    LOGOUT
		  </a>
		  &nbsp;
		   <a class="item">
		 <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
		  </a>
		  	<?php if(Session::get('user')['type']== "super admin"):?>
				   <a class="item" href="/LDProductAdvance/create_activation_code">
						Create Activation Code
				  </a>
				  <a class="item" href="/LDActivation/history_activation_code">
						Activation Code History
				  </a>
			<?php endif; ?>
		</div>

		<div class="ui grid">
			<?php require_once VIEWS.DS.'lending/template/sidebar.php'?>
			<div class="twelve wide column">
				<div class="ui segment">
					<!-- BINARY -->
					<div class="tree">
			<ul>
				<li>
					<?php ddbi_binary_branch($user)?>
			        <ul>
						<li>
							<?php ddbi_binary_branch($geneology['level2']['1.1'])?>
							<ul>
								<li>
									<?php ddbi_binary_branch($geneology['level3']['1.1'])?>
									<ul>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.1'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.1'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.2'])?></li>
											</ul>	
										</li>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.2'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.3'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.4'])?></li>
											</ul>			
										</li>
									</ul>
								</li>
								<li>
									<?php ddbi_binary_branch($geneology['level3']['1.2'])?>	
									<ul>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.3'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.5'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.6'])?></li>
											</ul>
										</li>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.4'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.7'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.8'])?></li>
											</ul>		
										</li>
									</ul>	
								</li>
							</ul>
						</li>

						<li>
							<?php ddbi_binary_branch($geneology['level2']['1.2'])?>
				            <ul>
				            	<li>
				            		<?php ddbi_binary_branch($geneology['level3']['1.3'])?>
				            		<ul>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.5'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.9'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.10'])?></li>
											</ul>
										</li>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.6'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.11'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.12'])?></li>
											</ul>	
										</li>
									</ul>	
				            	</li>
				            	<li>
				            		<?php ddbi_binary_branch($geneology['level3']['1.4'])?>
				            		<ul>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.7'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.13'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.14'])?></li>
											</ul>
										</li>
										<li>
											<?php ddbi_binary_branch($geneology['level4']['1.8'])?>
											<ul>
												<li><?php ddbi_binary_branch($geneology['level5']['1.15'])?></li>
												<li><?php ddbi_binary_branch($geneology['level5']['1.16'])?></li>
											</ul>							
										</li>
									</ul>	
				            	</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
					<!-- -->
				</div>
			</div>
		</div>
	</main>
</body>