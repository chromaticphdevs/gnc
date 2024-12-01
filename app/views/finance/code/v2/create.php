<?php build('content')?>
	<div class="row">
	    <div class="col-md-6">
	        <h4>Activation Codes / Create</h4>
	    </div>
	    <div class="col-md-6 text-right">
	        <a href="/FNCodeInventory/" class="btn btn-primary">
	            <i class="fa fa-list"></i>
	        </a>
	    </div>
	</div>


	<div class="well">
		<?php
			Form::open([
				'method' => 'post',
				'action' => '/FNCodeInventory/store'
			]);
		?>

		<div class="form-group">
			<?php
				Form::label('Select Activation Code');

				Form::select('codeid' , arr_layout_keypair($codeStorages , 'id' , 'name') , '' ,['class' => 'form-control']);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Select Branch');

				Form::select('branchid' , arr_layout_keypair($branches , 'id' , 'name') , '' ,['class' => 'form-control']);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Company');

				Form::select('companies' , $companies , 'break-through' ,['class' => 'form-control']);
			?>
		</div>

		<div class="form-group">
			<?php
				Form::label('Quantity');

				Form::number('quantity' , '' , ['class' => 'form-control']);

				Form::small('Number of codes that will be produced');
			?>
		</div>
		<input type="submit" name="" 
			class="btn btn-primary btn-sm" value="Save Codes">
		<?php Form::close()?>
	</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>