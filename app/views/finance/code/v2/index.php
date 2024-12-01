<?php build('content')?>
	<div class="row">
	    <div class="col-md-6">
	        <h4>Activation Codes</h4>
	    </div>

	    <div class="col-md-6 text-right">
	    	<?php if(isset($_GET['filter'])) :?>
	    	<a href="/FNCodeInventory" class="btn btn-warning">
	            <i class="fa fa-times"></i>
	        </a>
	    	<?php endif?>
	    	<a href="javascript:void(0)" class="btn btn-primary" 
	    		id="filterToggle">
	            <i class="fa fa-search"></i>
	        </a>
	        <a href="/FNCodeInventory/create" class="btn btn-primary">
	            <i class="fa fa-plus"></i>
	        </a>

	        <a href="/FNCodeStorage/" class="btn btn-warning">
	            Code Libraries
	        </a>
	    </div>
	</div>

	<div id="filter">
		<h5>Result Filter</h5>
		<?php
			Form::open([
				'method' => 'get',
				'action' => '',
				'class'  => 'form-inline'
			]);
		?>

		<div class="form-group">
			<?php
				Form::select('branch_id', arr_layout_keypair($branches , 'id' , 'name') , '' ,
				['class' => 'form-control']);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::select('level', $levels , '' ,
				['class' => 'form-control']);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::select('status', $status , 'available' ,
				['class' => 'form-control']);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::number('limit' , '' , ['class' => 'form-control' , 'placeholder' => 'Result Limiter']);
			?>
		</div>

		<div class="form-group">
			<button type="submit" name="filter"
				class="btn btn-primary btn-sm">
			<i class="fa fa-search"></i> <small>Apply Search</small>		
			</button>
		</div>
		<?php Form::close()?>
	</div>


	<div class="well">
		<table class="table">
		  <thead>
		    <th>#</th>
		    <th>Branch</th>
		    <th>Code</th>
		    <th>Amount</th>
		    <th>BOX EQ</th>
		    <th>Level</th>
		    <th>DRC</th>
		    <th>UNILVL</th>
		    <th>BP</th>
		    <th>COMP</th>
		    <th>Status</th>
		  </thead>

		  <tbody>
		    <?php foreach($codes as $key => $row) :?>
		      <tr>
		        <td><?php echo ++$key?></td>
		        <td><?php echo $row->branch_name?></td>
		        <td><?php echo $row->code?></td>
		        <td><?php echo $row->amount?></td>
		        <td><?php echo $row->box_eq?></td>
		        <td><?php echo $row->level?></td>
		        <td><?php echo $row->drc_amount?></td>
		        <td><?php echo $row->unilevel_amount?></td>
		        <td><?php echo $row->binary_point?></td>
		        
		        <td><?php echo $row->company?></td>
		        <td>
		          <p style="max-width: 300px;"><?php echo $row->status?></p>
		        </td>
		      </tr>
		    <?php endforeach;?>
		  </tbody>
		</table>
	</div>
<?php endbuild()?>


<?php build('scripts')?>
<script type="text/javascript">
	$(document).ready(function(evt) 
	{
		$("#filter").hide();
		$("#filterToggle").click( toggleFilter )
	});

	function toggleFilter()
	{
		$("#filter").toggle();
	}
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>