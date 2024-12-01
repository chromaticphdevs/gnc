<?php build('content')?>
	
	<div class="text-center">
		<h2>
			Timesheet story <br/>
			PHP <span id="totalHTML">0.0</span>
		</h2>
		<a href="/timekeeping/getUser/<?php echo $accountToken?>">
			<h4>Return</h4>
		</a>
	</div>
	<div class="row">
	<?php $total = 0?>
	<?php foreach($timesheets as $key => $timesheet) :?>
		<?php floatval($total += $timesheet->amount)?>
		<?php $timesheetClass = uniqid('t' , true)?>
		<div class="card timesheet-card photos col-md-3 <?php echo $timesheetClass?>">
			<div class="card-header">
				<h4 class="timesheetHeader">
				Timekeeping Card</h4>
			</div>
			<div class="card-body">
				<?php if(!empty($timesheet->photos)): ?>

					<?php $photosContainerName = uniqid('photos-');?>
					<?php $imageUpdate = "IMG".$timesheet->id?>
					<?php
						$photos = [];
						foreach($timesheet->photos as $photo) {
							$photos [] = $photo->file_path.'/'.$photo->file_name;
						}
					?>
					<div>
						<img src="<?php echo $photos[0]?>" id="<?php echo $imageUpdate?>">
						<input type="hidden" name='<?php echo $photosContainerName?>' 
						value='<?php echo json_encode($photos)?>'>
					</div>
					<a href="javascript:void(0)" class="tap-slider"
						data-photo_container="<?php echo $photosContainerName?>"
						data-current="0"
						data-next="1"
						data-origin="#<?php echo $imageUpdate?>">
						Tap to slide
					</a>
				<?php else:?>
					<div style="width: 100%;height: 200px; background:#eee; display: block;">
						
					</div>
					<small>No Image</small>
				<?php endif?>
				<div class="text-center">
					<h4> <strong><?php echo $timesheet->amount?></strong> </h4>
					<ul>
						<li>Work Hours : <?php echo minutesToHours($timesheet->duration)?></li>
						<li>Timelogs : <?php echo $timesheet->time_in . ' ' .$timesheet->time_out?></li>
						<li>Rate : <?php echo $timesheet->meta->rate?></li>
					</ul>

					<?php if(! isEqual($timesheet->status , 'approved')) :?>
						<a href="javascript:void(0)" 
							data-sheetid="<?php echo $timesheet->id?>"
							data-target="<?php echo $timesheetClass?>"
							class="btn btn-primary btn-block accept-timesheet">Accept</a>
					<?php endif?>
				</div>
			</div>
		</div>
	<?php endforeach?>
	</div>

	<input type="hidden" name="" id="totalValue" value="<?php echo $total?>">
<?php endbuild()?>

<?php build('headers')?>
<style type="text/css">
	.photos img{
		width: 300px;
		height: 200px;
		margin: 0px;
		padding: 0px;
		display: block;
	}
	.card{
		box-shadow: border-box;
		border: 1px solid #000;
	}
	.timesheet-card img{
		width: 100%;
	}
	.selected-timesheet {
		/*background-color: #11d32d;*/

		display: none;
	}
</style>
<?php endbuild()?>

<?php build('scripts')?>
	
	<script type="text/javascript">

	$( document ).ready( function(evt) {

		$("#totalHTML").html( $("#totalValue").val() );
	
		// var endpoint = 'http://dev.bktktool/api/timesheet/approve';
		var endpoint = 'https://app.breakthrough-e.com/api/timesheet/approve';

		$(".tap-slider").click( function(evt) 
		{
			let ahref = $(this);

			let currentImage = parseInt(ahref.data('current'));
			let nextImage = parseInt(ahref.data('next'));
			let photoContainer = ahref.data('photo_container');

			let photos = $(`input[name='${photoContainer}']`).val();

			let parsedPhotos = JSON.parse(photos);
			let count = parseInt(parsedPhotos.length);
			let origin = ahref.data('origin');

			$(`${origin}`).attr('src', parsedPhotos[nextImage]);

			//update nextImage

			if(nextImage < count) 
			{
				currentImage++;
				nextImage++;

				ahref.data('next' , nextImage);
				ahref.data('current' , currentImage);

			}else if(nextImage == count) {
				currentImage++;
				//reset next image when count is maxed
				nextImage = 0;
				ahref.data('next' , nextImage);
				ahref.data('current' , currentImage);
			}
		});


		$('.timesheetHeader').click( function(evt) 
		{
			let target = $(this).data('target').trim();

			console.log(target);

			let targetIsChecked =  $(target).is(':checked');

			if(targetIsChecked) 
			{
				$(target).prop('checked' , false);
				$(this).addClass('selected-timesheet');
			}else{
				$(target).prop('checked' , true);
				$(this).removeClass('selected-timesheet');
			}

		});


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
		/*Approve time sheet*/

		// let endpoint = 'https://app.breakthrough-e.com/api/timesheet/approve';
		
	});
	</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>

