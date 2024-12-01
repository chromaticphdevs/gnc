<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Payout'))?>
            <div class="card-body">
            <section class="x_content">
                    <?php Flash::show()?>
                    <hr>
                    <!--<?php if(!empty($forPayout['details'])) :?>
                        <div>
                            <div><strong>Previous</strong></div>
                            From : <strong><?php echo $forPayout['details']->datestart?></strong>
                            To: <strong><?php echo $forPayout['details']->dateend?></strong>
                        </div>

                        <div>
                            <div><strong>Current</strong></div>
                            From : <strong><?php echo $forPayout['details']->dateend?></strong>
                            To: <strong><?php echo date('Y-m-d h:i:s A')?></strong>
                        </div>
                        <?php else:?>
                        <div>
                            From the start until today.
                        </div>
                    <?php endif;?>-->
                    <section>
                        
                        <?php if(isset($payins) &&!empty($payins)) :?>
                            <h3>Total Payin : <b><?php echo to_number($payins['total'])?></b></h3>
                        <?php endif;?>
                        <h3>Total Payout : <b><?php echo to_number($forPayout['total']);?></b></h3>
                        <h3>Product Release Unpaid Total: <b><?php echo to_number($total_not_paid)?></b> </h3>
                        

                        <?php if(isset($payoutPercentage)) :?>
                            <!--<h3>Payout Percentage : <?php echo $payoutPercentage?></h3>-->
                        <?php endif;?>
                        <form action="/MGPayout2/create_payout_valid_id" method="post" id="payout">
                            <div class="form-group">
                                <input type="hidden" name="amount" value="<?php echo $_GET['amount']; ?>">
                                <input type="submit"  value="&nbsp;&nbsp;Make cheque&nbsp;&nbsp;" class="btn btn-primary btn-sm verifiy-action"  >
                            </div>
                        </form>
                        <br><br>
                        <!--export to excel-->
                        <form action="/MGPayout2/export" method="post">
                            <input type="hidden" name="users" 
                                value="<?php echo base64_encode(serialize($forPayout['list']))?>">

                            <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
                         </form>

                    </section>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Amount Payout</th>
                                </thead>

                                <tbody>
                                    <?php $totalAmount = 0 ?>
                           
                                   
                                    <?php foreach($forPayout['list'] as $key => $payout) :?>
                                       
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $payout->username?></td>
                                                <td><?php echo $payout->fullname?></td>
                                                <td><?php echo to_number($payout->amount)?></td>
                                            </tr>

                                    <?php endforeach;?>
                                </tbody>
                            </table>

                            <h4>Paid Products</h4> 
                              <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Level</th>
                                        <th></th>
                                    
                                    </thead>

                                    <tbody>
                                        <?php foreach($products_amount_count as $key => $row) :?>
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $row->amount?></td>
                                                <td><?php
                                                        if($row->amount == 1500){
                                                            echo "Starter";
                                                        }elseif ($row->amount == 16000) {
                                                            echo "Silver";
                                                        }elseif ($row->amount == 46500) {
                                                            echo "Gold";
                                                        }else{
                                                            echo "";
                                                        }

                                                    ?>        
                                                </td>
                                                <td><?php echo $row->count?></td>
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>

                                <h4>Unpaid Products</h4>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Level</th>
                                        <th></th>
                                    
                                    </thead>

                                    <tbody>
                                        <?php foreach($unpaid_amount_count as $key => $row) :?>
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $row->amount?></td>
                                                <td><?php
                                                        if($row->amount == 1500){
                                                            echo "Starter";
                                                        }elseif ($row->amount == 16000) {
                                                            echo "Silver";
                                                        }elseif ($row->amount == 46500) {
                                                            echo "Gold";
                                                        }else{
                                                            echo "";
                                                        }

                                                    ?>        
                                                </td>
                                                <td><?php echo $row->count?></td>
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                        </div>
                        <div class="col-md-6">
                            <?php if(isset($payins) &&!empty($payins)) :?>
                                <!--<h3>Total Payin : <?php echo to_number($payins['total'])?></h3>-->
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Origin</th>
                                        <th>Date and time</th>
                                    </thead>

                                    <tbody>
                                        <?php foreach($payins['list'] as $key => $row) :?>
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $row->amount?></td>
                                                <td><?php echo $row->type?></td>
                                                <td><?php echo $row->origin?></td>
                                                <td><?php echo $row->dateandtime?></td>
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                            <?php endif;?>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<script defer>
    $(document).ready(function() {
    $("#payout").on('submit' , function(e)
    {
        if (confirm("Are You Sure?")) 
        {
            return true;
        }else
        {
            return false;
        }
    });
    });
</script>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>