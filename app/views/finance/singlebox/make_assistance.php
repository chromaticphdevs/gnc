<?php build('content') ?>
<h3>Product Advance</h3>
<?php Flash::show()?>
<div class="well">
    <section>
        <p class="alert alert-warning"> 
            <span>Product Advance Requirements:</span> user must have a <strong>left and right downline</strong> 
        </p>
    </section>
    <div class="row">
        <section class="col-md-6">
            <h3>Product Claim Codes</h3>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Reference</th>
                    <th>Branch</th>
                    <th>Status</th>
                </thead>

                <tbody>
                    <?php foreach($productClaimCodes as $key => $row) :?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->reference?></td>
                            <td><?php echo $row->branch_name?></td>
                            <td><?php echo $row->status?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </section>                  

        <section class="col-md-6">
            <h3>Activation Codes</h3>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Code</th>
                    <th>Status</th>
                </thead>

                <tbody>
                    <?php foreach($activations as $key => $row) :?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->code?></td>
                            <td><?php echo $row->status?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<div class="well">
    <?php if(isset($userDownline)):?>
        <div class="row">
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>Request Product Advance</h3>
                        <?php if($user['account_tag'] == 'main_account'):?>
                        <form action="" method="post">
                            <input type="hidden" name="addtionalBoxes" 
                            value="<?php echo $addtionalBoxes?>">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-sm" 
                                value="Request Product Advance">
                            </div>
                        </form>
                        <?php else:?>
                            <h3>Not Avaiable on Secondary Accounts.</h3>
                        <?php endif?>
                    </div>
                </div>
            </div>

            <div class="col-md-2"></div>

            <div class="col-md-7">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>Product Advance Logs</h3>

                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </thead>

                            <tbody>
                                <?php foreach($assistanceLogs as $key => $row) :?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $row->code?></td>
                                        <td><?php echo $row->amount?></td>
                                        <td><?php echo $row->status?></td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php else:?>
        <div class="x_panel">
            <div class="x_well">
                <p>Seems like you don't have the requirements yet to have product advance , <a href="#">Help me.</a></p>
            </div>
        </div>
    <?php endif;?>
</div>
<?php endbuild()?>


<?php occupy('templates/layout')?>