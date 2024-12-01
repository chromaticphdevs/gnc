<?php build('content') ?>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Petty Cash</h4>
            <a href="/PettyCashController/">Back To List</a>
        </div>

        <div class="card-body">
            <?php
                Form::open([
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]);
                Form::hidden('id', $pettyCash->id);
                Form::hidden('user_id', whoIs()['id']);
            ?>
                <div class="form-group">
                    <?php
                        Form::label('Title *');
                        Form::text('title', $pettyCash->title, [
                            'class' => 'form-control',
                            'required' => true
                        ]);
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                Form::label('Amount *');
                                Form::text('amount', $pettyCash->amount, [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                Form::label('Entry Type *');
                                Form::select('entry_type',['add','deduct'], $pettyCash->entry_type,[
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Entry Date *');
                        Form::date('entry_date',$pettyCash->entry_date,[
                            'class' => 'form-control',
                            'required' => true
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Description');
                        Form::textarea('description',$pettyCash->description, [
                            'class' => 'form-control',
                            'rows' => 4
                        ]);
                    ?>
                </div>
                
                <div class="mt-2">
                    <?php Form::submit('change_main', 'Save Entry', [
                        'class' => 'btn btn-sm btn-primary'
                    ])?>

                    <a href="/PettyCashController/show/<?php echo $pettyCash->id?>" class="btn btn-danger btn-sm">Cancel</a>
                </div>
            <?php Form::close()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>