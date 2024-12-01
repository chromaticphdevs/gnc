<?php build('content') ?>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Petty Cash</h4>
            <a href="/PettyCashController/">Back to list</a>
        </div>

        <div class="card-body">
                <?php
                    Form::open([
                        'method' => 'post',
                        'enctype' => 'multipart/form-data'
                    ]);

                    Form::hidden('user_id', whoIs()['id']);
                ?>
                <?php if(Session::get('USERSESSION')['type'] == 1) :?>
                <div class="form-group">
                    <?php
                        Form::label('Username *');
                        Form::text('username','', [
                            'class' => 'form-control',
                            'required' => true
                        ]);
                    ?>
                </div>
                <?php endif?>
                
                <div class="form-group">
                    <?php
                        Form::label('Title *');
                        Form::text('title','', [
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
                                Form::text('amount','', [
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
                                Form::select('entry_type',['add','deduct'], 'deduct',[
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
                        Form::date('entry_date',today(),[
                            'class' => 'form-control',
                            'required' => true
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Description');
                        Form::textarea('description','', [
                            'class' => 'form-control',
                            'rows' => 4
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('File Upload');
                        Form::file('file');
                    ?>
                </div>

                
                <div class="mt-2">
                    <?php Form::submit('', 'Save Entry', [
                        'class' => 'btn btn-sm btn-primary'
                    ])?>
                </div>
            <?php Form::close()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>