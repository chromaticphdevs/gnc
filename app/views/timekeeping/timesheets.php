<?php  build('content') ?>
	<h3>Timesheets</h3>
	<a href="?">All</a> | 
	<a href="?status=approved">Approved</a> | 
	<a href="?status=pending">Pending</a> |

	<?php $status = $_GET['status'] ?? ''?>
	<?php $groupByEmployee = $_GET['employee'] ?? false ?>
	<?php
		Form::open([
			'method' => 'post',
			'action' => '/timekeeping/bulkAction'
		]);
	?>
	<?php $hasBulkedAction = isEqual($_GET['status'] ?? '', 'pending') ? TRUE : FALSE;?>

	<?php if($hasBulkedAction) :?>
		<section>
			<h4>Bulk Commands</h4>
			<div class="form-group">
				<?php Form::select('action' , ['Delete' , 'Approve'] , '' , ['class' => 'form-control'])?>
			</div>
			<?php Form::submit('_submit_action' , 'Run Bulk Action' , ['class' => 'btn btn-primary btn-sm'])?>
		</section>
	<?php endif?>

	<small>Click Employee name to group them</small>
	<?php if($groupByEmployee):?>
		<a href="?status=<?php echo $status?>">Remove Group by Employee</a>
	<?php endif?>

	<div class="table-responsive">
	    <table class="table">
	        <thead>
	            <th>#</th>
	            <th>User</th>
	            <th>Time In</th>
	            <th>Time Out</th>
	            <th>Duration</th>
	            <th>Rate</th>
	            <th>Allowance</th>
	            <th>Status</th>
	            <th>Action</th>
	        </thead>

	        <tbody>
	        	<?php $total = 0?>
	        	<?php $counter = 0 ?>
	            <?php foreach($timesheets as $key => $row): ?>
	            
	            <?php 
	            	/*
	            	*SKIP NOT OWNED TOTAL
	            	*/
	            	if($groupByEmployee && !isEqual($groupByEmployee , $row->employee_name)){
	            		continue;
	            	}
	            ?>

	            <?php $total += $row->amount?>
	            <?php 
	            	$target = get_token_random_char(12);
	            	$targetTR = get_token_random_char(12);
	            ?>
	            
	            <tr class="<?php echo $targetTR?>">
	                <td>
						<?php if($hasBulkedAction) :?>
							<input type="checkbox" name="timesheetIds[]" value="<?php echo $row->id?>" checked>
						<?php else:?>
							<?php echo intval(++$counter)?>
						<?php endif?>
					</td>
	                <td>
	                	<a href="?status=<?php echo $status.'&employee='.$row->employee_name?>"> <?php echo $row->employee_name?></a>
	                </td>
	                <td><?php echo get_date($row->time_in, 'M d,Y h:i:s A')?></td>
	                <td><?php echo get_date($row->time_out, 'M d,Y h:i:s A')?></td>
	                <td><?php echo minutesToHours($row->duration)?></td>
	                <td><?php echo $row->meta->rate?></td>
	                <td><?php echo $row->amount?></td>
	                <td><label class="<?php echo $target?>"><?php echo $row->status?></label></td>
	                <td>
	                	<?php 
	                		if(!isEqual($row->status , 'approved') && $hasBulkedAction):
	                		/*Show button if status is not approved*/
	                	?>
	                	<a href="#" data-sheetid="<?php echo $row->id?>" 
	                		class='btn-approve btn btn-success btn-sm' 
	                		data-target=".<?php echo $target?>"
	                		data-tr = ".<?php echo $targetTR?>"> Approve </a>
	                	<?php endif;?> 
	                	<a href="/timekeeping/timesheetShow/<?php echo $row->id?>" target="_blank" class="btn btn-primary btn-sm"> Show </a>
	                	<a href="/timekeeping/deleteTimesheet/<?php echo $row->id?>&token=<?php echo $tkAppSession?>"
	                		class='btn btn-danger btn-sm'> Delete </a>
	                </td>
	            </tr>
	            <?php endforeach?>
	        </tbody>
	    </table>
	</div>
	<?php Form::close()?>
	<div>
		<h4>Total : <?php echo to_number($total)?></h4>
	</div>
<?php endbuild()?>

<?php build('scripts')?>
	<script type="text/javascript">
		
		$( document ).ready( function() 
		{
			let endpoint = 'https://app.breakthrough-e.com/api/timesheet/approve';
			// let endpoint = 'http://dev.bktktool/api/timesheet/approve';
			
			$('.btn-approve').click( function(evt) 
			{
				let sheetId = $(this).data('sheetid');

				var target  = $(this).data('target');
				var targetTR  = $(this).data('tr');
				
				//if( confirm('this action is irrevisable') )
				//{
					$.post(endpoint , {
						id : sheetId
					}, function(response)
					{
						$(target).html('approved');
						$(targetTR).remove();
					});
				//}
				
			});
		});
	</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>