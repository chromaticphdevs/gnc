<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonRight('Bank Accounts',[
            $navigationHelper->setNav('', 'Add New Bank', '/UserBankController/create')
        ])?>
        <div class="card">
            <?php echo wCardHeader(wCardTitle('User Bank')) ?>
            <div class="card-body">
                <?php Flash::show()?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Organization</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php foreach($userBanks as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo ucwords($row->org_name) ?></td>
                                    <td><?php echo $row->account_number?></td>
                                    <td><?php echo $row->account_name?></td>
                                    <td><a href="/UserBankController/edit/<?php echo $row->id?>">Edit Account</a></td>
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