<?php build('content')?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Approved Qualifiers</h4>
            <a href="/FNCashAdvance/index/">Loans</a> | 
            <a href="/FNCashAdvance/index/?page=qualifiers">Qualifiers</a> | 
            <a href="/FNCashAdvance/index/?page=qualifiers_approved">Approved Qualifiers</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Member</th>
                        <th>Approved By</th>
                        <th>Approved Date</th>
                        <th>Loan</th>
                    </thead>

                    <tbody>
                        <?php foreach($qualifiers_approved as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->full_name?></td>
                                <td><?php echo $row->approver_name?></td>
                                <td><?php echo $row->approval_date?></td>
                                <td><?php echo $row->loan_type?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>