<?php build('content')?>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Information</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Username : </td>
                                <td><?php echo $user->username?></td>
                            </tr>
                            <tr>
                                <td>Name : </td>
                                <td><?php echo $user->lastname . ', ' . $user->firstname?></td>
                            </tr>
                            <tr>
                                <td>Email : </td>
                                <td><?php echo $user->email?></td>
                            </tr>
                            <tr>
                                <td>Mobile : </td>
                                <td><?php echo $user->mobile?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Loans</h4>
                    <h1>Remaning Balance : <?php echo number_format($loanBalance, 2)?></h1>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tale-bodered">
                            <thead>
                                <th>Reference</th>
                                <th>Initial Amount</th>
                                <th>Balance</th>
                                <th>Pay</th>
                            </thead>
                            <?php foreach($loans as $key => $row) :?>
                                <tr>
                                    <td><?php echo $row->reference?></td>
                                    <td><?php echo $row->amount?></td>
                                    <td><?php echo $row->remaining_balance?></td>
                                    <td>
                                        <?php
                                            Form::open([
                                                'method' => 'post'
                                            ]);

                                            Form::hidden('loan_id',$row->id);
                                            Form::hidden('user_id',$user->id);
                                        ?>
                                        <div class="row">
                                        <?php Form::text('amount',$row->remaining_balance,['class' => 'form-control','requried' => true])?>
                                        <?php Form::submit('btn_pay','Pay')?>
                                        </div>
                                        <?php Form::close()?>
                                    </td>
                                </tr>
                            <?php endforeach?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>