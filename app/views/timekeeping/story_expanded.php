<?php build('content') ?>
	<a href="/timekeeping/getUser/<?php echo $accountToken?>">
		<h4>Return </h4>
	</a>
	<?php foreach($timesheets as $key => $timesheet) :?>
		<div class="timesheet">
			<h4><strong>PHP : <?php echo $timesheet->amount?></strong>(<?php echo minutesToHours($timesheet->duration) ?>)</h4>
			<?php if(!empty($timesheet->photos)):?>
				<div class="row timesheet-img">
					<?php foreach($timesheet->photos as $photo) :?>
						<div class="col-md-3">
							<img src="<?php echo $photo->file_path.DS.$photo->file_name?>">
						</div>
					<?php endforeach?>
				</div>
			<?php endif;?>
			<h4><?php echo $timesheet->time_in .' to ' . $timesheet->time_out?></h4>

			<?php if(!isEqual($timesheet->status , 'approved')) :?>
				<a href="javascript:void(0)" data-sheetid="<?php echo $timesheet->id?>"
					class="btn btn-primary accept-timesheet">Accept</a>
			<?php endif?>
		</div>
	<?php endforeach?>
<?php endbuild()?>

<?php build('headers')?>
	<style type="text/css">
		.timesheet{
			box-sizing: border-box;
			background-color: #eee;
			padding: 10px;
			margin: 10px;
		}
		.timesheet-img img {
			width: 300px;
			height: 250px;
		}
	</style>
<?php endbuild()?>


<?php build('scripts')?>
	
	<script type="text/javascript">
		// var endpoint = 'http://dev.bktktool/api/timesheet/approve';
		var endpoint = 'https://app.breakthrough-e.com/api/timesheet/approve';
		$( document).ready(function(evt) {

		$('.accept-timesheet').click( function(evt) 
		{

			let sheetId = $(this).data('sheetid');
			let target = $(this).data('target');

			let self = $(this);

			$.post(endpoint , {
				id : sheetId
			}, function(response)
			{
				self.remove();
				response = JSON.parse(response);

				alert(response.data);
			});	

		});

		});
	</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>