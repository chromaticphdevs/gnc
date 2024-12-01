<?php build('content')?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Petty Cash</h4>
        <a href="/PettyCashController/create">Create Petty Cash</a>
    </div>
    <div class="card-body">
        <h4>AVAILABLE BALANCE : <?php echo ui_html_amount($petty_cash_balance)?></h4>
        <hr>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Date Recorded</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach($petty_transactions as $key => $row) :?>
                        <tr>
                            <td><?php echo $row->updated_at?></td>
                            <td><?php echo ui_html_amount($row->amount)?></td>
                            <td><?php echo $row->entry_date?></td>
                            <td><?php echo $row->title?></td>
                            <td><?php echo $row->status?></td>
                            <td>
                                <a href="/PettyCashController/show/<?php echo $row->id?>">Show Details</a>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>