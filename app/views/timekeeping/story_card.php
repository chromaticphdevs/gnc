<?php build('content') ?>
	
	<div class="row">
		<?php for($i = 0 ; $i < 5 ; $i++) :?>
			<div class="card col-md-4 mx-auto timesheet-card">
				<div class="card-header">
					<h4>Timekeeping Card</h4>
				</div>

				<div class="card-body">
					<img src="http://dev.bktktool\public/uploads\10_7CA1F97EF8D71D3.PNG">
					<small>Tap photo to slide</small>
					<div class="text-center">
						<h4> <strong>300.00</strong> </h4>
						<ul>
							<li>Work Hours : 6hrs</li>
							<li>Timelogs : 10:30 - 2:00</li>
							<li>Rate : 300</li>
						</ul>

						<a href="#" class="btn btn-primary btn-block">Accept</a>
					</div>
				</div>
			</div>
		<?php endfor?>
	</div>
<?php endbuild()?>

<style type="text/css">
	.card{
		box-shadow: border-box;
		display: inline-block;
		border: 1px solid #000;
		margin: 10px auto;
	}
	.timesheet-card img{
		width: 100%;
	}
</style>
<?php occupy('templates/layout')?>