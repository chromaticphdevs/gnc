<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Penalties</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                        <th>#</th>
                        <th>Loan Reference</th>
                        <th>Borrower Name</th>
                        <th>Message</th>
                        <th>Penalty Category</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </thead>

                    <tbody>
                        <?php $totalPenalty = 0?>
                        <?php foreach($penalties as $key => $row) :?>
                            <?php $totalPenalty += $row->amount?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><a href="/CashAdvanceReleaseController/show/<?php echo $row->release_id?>"><?php echo $row->loan_reference?></a></td>
                                <td><?php echo $row->borrower_fullname?></td>
                                <td><?php echo $row->remarks?></td>
                                <td><?php echo $row->loan_attribute?></td>
                                <td><?php echo ui_html_amount($row->amount)?></td>
                                <td><?php echo $row->penalty_date?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>

            <h3>Total Incured Penalty : <?php echo ui_html_amount($totalPenalty)?></h3>
        </div>
    </div>
<?php endbuild() ?>
<?php occupy() ?>