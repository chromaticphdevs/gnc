<?php build('content') ?>
	
	<h1>Trashed Timesheets</h1>

	<?php Form::open([
		'method' => 'post',
		'action' => '/TimesheetTrash/bulkAction'
	])?>

	<section>
		<h4>Bulk Commands</h4>
		<div class="form-group">
			<?php Form::select('action' , ['Restore' , 'Move to Trash'] , '' , ['class' => 'form-control'])?>
		</div>
		<?php Form::submit('_submit_action' , 'Run Bulk Action' , ['class' => 'btn btn-primary btn-sm'])?>
	</section>

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
	            <?php foreach($timesheets as $key => $row): ?>
	            <?php $target = get_token_random_char(12)?>
	            <?php $total += $row->amount?>
	            <tr>
	                <td>
						<input type="checkbox" name="timesheetIds[]" value="<?php echo $row->id?>" checked>
					</td>
	                <td><?php echo $row->employee_name?></td>
	                <td><?php echo date_long($row->time_in, 'M d,Y h:i:s A')?></td>
	                <td><?php echo date_long($row->time_out, 'M d,Y h:i:s A')?></td>
	                <td><?php echo minutesToHours($row->duration)?></td>
	                <td><?php echo $row->meta->rate?></td>
	                <td><?php echo $row->amount?></td>
	                <td><label class="<?php echo $target?>"><?php echo $row->status?></label></td>
	                <td>
	                	<a href="/TimesheetTrash/restore/?timesheetIds=<?php echo $row->id?>&token=<?php echo $tkAppSession?>" class="btn btn-primary btn-sm" title="restore"> <i class="fa fa-undo"></i> </a>

	                	<a href="/TimesheetTrash/moveToTrash/?timesheetIds=<?php echo $row->id?>&token=<?php echo $tkAppSession?>"
	                		class='btn btn-danger btn-sm' title="Move to trash">
	                			<i class="fa fa-trash"></i>
	                		</a>
	                </td>
	            </tr>
	            <?php endforeach?>
	        </tbody>
	    </table>
	</div>
	<?php Form::close()?>
<?php endbuild()?>
<?php occupy('templates/layout')?>