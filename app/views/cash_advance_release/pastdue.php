<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Past Due</h4>
        </div>

        <div class="card-body">
        <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Loan Reference</th>
                        <th>Borrower name</th>
                        <th>Borrower username</th>
                        <th>Amount</th>
                        <th>Initial Balance</th>
                        <th>Balance</th>
                        <th>Release Date</th>
                        <th>Release Date Span</th>
                    </thead>

                    <tbody id="releaseRows">
                        <?php 
                            $totalAmount = 0;
                            $totalBalance = 0;
                        ?>
                        <?php foreach($pastdueList as $key => $row) :?>
                            <?php
                                $totalAmount += $row->amount;
                                $totalBalance += $row->loan_balance;    
                            ?>

                            <tr data-id="<?php echo $row->id?>">
                                <td><?php echo ++$key?></td>
                                <td><a href="/CashAdvanceReleaseController/show/<?php echo $row->id?>"><?php echo $row->loan_reference?></a></td>
                                <td><?php echo $row->member_name?></td>
                                <td><?php echo $row->username?></td>
                                <td><?php echo $row->amount?></td>
                                <td><?php echo $row->loan_net?></td>
                                <td><?php echo $row->loan_balance?></td>
                                <td><?php echo $row->entry_date?></td>
                                <td><?php echo $row->release_date_span?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <h4>Total Amount : <?php echo ui_html_amount($totalAmount)?></h4>
            <h4>Total Balance : <?php echo ui_html_amount($totalBalance)?></h4>
        </div>
    </div>
<?php endbuild() ?>
<?php occupy()?>