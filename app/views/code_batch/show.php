<?php build('content') ?>
<div class="card">
        <div class="card-header">
            <h4 class="card-title">Batch : <?php echo $batch->batch_code?> </h4>
            <a href="/codeBatchController/">Back To List</a>
            <!-- <a href="/CodeBatchController/print/<?php echo $batch->batch_code?>" class="btn btn-primary btn-sm" id="print_btn">Print</a> -->
            <?php Flash::show()?>
        </div>
        <div class="card-body">

            <section class="col-md-4">
                <h4>Send Random Codes to a user</h4>
                <?php
                    Form::open([
                        'method' => 'post'
                    ]);

                    Form::hidden('batch_id', $batch->id);
                ?>
                <div class="form-group">
                    <?php
                        Form::label('Username');
                        Form::text('username' ,'' , ['class' => 'form-control']);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Quantity');
                        Form::number('quantity' , '' , ['class' => 'form-control']);
                    ?>
                </div>

                <div class="form-group">
                    <?php Form::submit('send_code','Send Codes'); ?>
                </div>

                <?php Form::close()?>
            </section>
            <div class="table">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Description</th>
                        <th>Created At</th>
                    </thead>

                    <tbody>
                        <?php foreach($codes as $key => $code) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td>
                                    <a href="/RaffleRegistrationController/register?code=<?php echo seal($code->code)?>">
                                        Register User
                                    </a>
                                </td>
                                <td><?php echo $code->description?></td>
                                <td><?php echo $code->created_at?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
        $("#print_btn").click( function(e) {

            if( confirm('Irrevisable Action Notice : Are you sure you want to print this batch? clicking okay will expire the codes printable status make sure this batch will be printed') ){
    
            }else{
                e.preventDefault();
            }
        });
    </script>
<?php endbuild()?>

<?php occupy('templates/layout')?>