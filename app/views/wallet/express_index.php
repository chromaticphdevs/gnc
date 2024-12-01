<?php build('content') ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Wallets</h2>
                <a href="/WalletController/expressSend">Express Send</a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Transaction</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            <?php foreach($wallets as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo '#'.$row->reference_id?></td>
                                    <td>
                                        <?php if($row->amount < 0) :?>
                                            <strong><span style="color:blue">Sender : <?php echo $row->beneficiary_fullname?></span></strong> | 
                                            <strong><span>Beneficiary : <?php echo $row->purchaser_fullname?></span></strong>
                                        <?php endif?>

                                        <?php if($row->amount > 0) :?>
                                            <strong><span>Sender : <?php echo $row->purchaser_fullname?></span></strong> | 
                                            <strong><span style="color:blue">Beneficiary : <?php echo $row->beneficiary_fullname?></span></strong>
                                        <?php endif?>
                                    </td>
                                    <td><?php echo to_number($row->amount)?></td>
                                    <td><?php echo $row->origin?></td>
                                    <td><?php echo $row->date?></td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>

                <h4>Current Wallet : <?php echo to_number($availableEarning)?></h4>
                <hr>
                <div>Recieve Wallet Through QR</div>
                <div><img src="<?php echo unseal($qrSource['srcURL'])?>" alt=""></div>
                <span>Send this QR-Code To Recieve Wallet</span>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>