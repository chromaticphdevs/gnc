<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Released Payments')) ?>
            <div class="card-body">
                <input type="text" id="keywordsearch" placeholder="Search here">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Member Name</th>
                            <th>Loan Reference</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </thead>

                        <tbody>
                            <?php foreach($releases as $key => $row) :?>
                                <tr data-id="<?php echo $row->id?>">
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->release_reference?></td>
                                    <td><?php echo $row->member_name?></td>
                                    <td><?php echo $row->loan_reference?></td>
                                    <td><?php echo $row->amount?></td>
                                    <td><?php echo $row->entry_date?></td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endbuild() ?>
    <?php build('scripts') ?>
        <script>
            $(document).ready(function(){
                // CashAdvanceReleaseController
                $('table tr').dblclick(function(e){
                    let dataId = $(this).data('id');
                    if(typeof dataId == 'undefined') {
                        return;
                    }
                    window.location.href = '/CashAdvanceReleaseController/show/'+dataId;
                });
            });
        </script>
    <?php endbuild()?>
<?php occupy()?>