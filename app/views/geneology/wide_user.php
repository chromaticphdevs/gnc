<?php build('content')?>
	
	<div class="card">
		<div class="card-header">
			<h4>Geneology</h4>

			<a href="?">Reset</a>
		</div>
		<hr>
		<div class="card-body">
			<h1><?php echo $user['username']?></h1>

			<div class="row">
				<div class="col-md-6">
					<h3>LEFT</h3>
					<?php $count = 0 ?>
					<?php foreach($geneology as $key => $row) :?>
						<?php $dateString = get_date($row->created_at , 'M d Y h:i:s a') ?>
						<?php if(isEqual($row->L_R  , 'right')) continue?>
						<div class="downline">
							<a href="?user_id=<?php echo $row->id?>">
								<?php echo $row->id.' | '.$row->username . ' | '.$row->firstname . ' | '.$dateString?>

								<?php if($count != 0):?>
								<div>
									<a href="?user_id=<?php echo $row->id?>&upline=<?php echo $geneology[$key -1]->id?>"
										class="btn btn-primary btn-sm">
										Change Upline
									</a>
								</div>
								<?php endif;?>
							</a>
						</div>
						<?php $count++?>
					<?php endforeach?>
				</div>
				<div class="col-md-6">
					<h3>RIGHT</h3>
					<?php $count = 0 ?>
					<?php foreach($geneology as $key => $row) :?>
						<?php $dateString = get_date($row->created_at , 'M d Y h:i:s a') ?>
						<?php if(isEqual($row->L_R  , 'left')) continue?>
						<div class="downline">
							<a href="?user_id=<?php echo $row->id?>">
								<?php echo $row->id.' | '.$row->username . ' | '.$row->firstname . ' | '.$dateString?>

								<?php if($count != 0):?>
								<div>
									<a href="?user_id=<?php echo $row->id?>&upline=<?php echo $geneology[$key -1]->id?>"
										class="btn btn-primary btn-sm">
										Change Upline
									</a>
								</div>
								<?php endif;?>
							</a>
						</div>
						<?php $count++?>
					<?php endforeach?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>

<?php build('headers') ?>

	<style type="text/css">
		.downline{
			padding: 10px;
			margin-bottom: 5px;
			background: #eee;
		}
	</style>
<?php endbuild()?>
<?php occupy('templates/layout')?>