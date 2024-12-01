<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h1 class="text-header">LEDGER</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Previous Balance</th>
                        <th>Ending Balance</th>
                        <th style="width: 30%;">Remarks</th>
                        <th>Date Time</th>
                    </thead>

                    <tbody>
                        <?php foreach($ledger_list as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->ledger_reference?></td>
                                <td><?php echo $row->category?></td>
                                <td><?php echo ui_html_amount($row->ledger_entry_amount)?></td>
                                <td><?php echo ui_html_amount($row->previous_balance)?></td>
                                <td><?php echo ui_html_amount($row->ending_balance)?></td>
                                <td><?php echo $row->description?></td>
                                <td><?php echo $row->entry_dt?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <h3>Ending Balance : <?php echo ui_html_amount($ending_balance)?></h3>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>