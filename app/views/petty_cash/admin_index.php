<?php build('content')?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Users PettyCash</h4>
            <a href="/PettyCashController/create">Create Petty Cash</a>
        </div>
        <div class="card-body">
            <h4>Users Petty Cash</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Username</th>
                        <th>Amount</th>
                        <th>Last Updated</th>
                    </thead>

                    <tbody>
                        <?php foreach($petty_cash_per_user as $key => $row) :?>
                            <tr>
                                <td><?php echo $row->fullname?></td>
                                <td><?php echo ui_html_amount($row->available_balance)?></td>
                                <td><?php echo $row->updated_at?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>

            <h4>Recent Logs</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Date Recorded</th>
                        <th>Name</th>
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
                                <td><?php echo $row->fullname?></td>
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
</div>
<?php endbuild()?>
<?php occupy()?>