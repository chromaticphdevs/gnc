<?php

use Mpdf\Shaper\Sea;

 build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Co Borrowing</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Loan Reference</th>
                        <th>Borrower</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($coBorrowers as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->code?></td>
                                <td><?php echo $row->firstname . ' ' .$row->lastname?></td>
                                <td><a href="/CashAdvance/loan/<?php echo seal($row->fn_ca_id)?>">Show Loan</a></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>