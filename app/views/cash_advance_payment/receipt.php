<?php build('content') ?>
    <div class="container-fluid">
        <div class="card" style="font-size: .75em;">
            <?php echo wCardHeader(wCardTitle('Payment Receipt'))?>
            <div class="card-body">
                <section class="heading">
                    <button class="btn btn-sm btn-primary mb-3" style="cursor: pointer;" id="printReciept">Print <i class="fa fa-print"></i></button>
                    <section class="mb-3">
                        <div class="text-center" style="background-color: #eee; padding:15px">
                            <h4><?php echo COMPANY_DETAILS['name']?></h4>
                            <div>Official Receipt</div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo COMPANY_DETAILS['logo']?>" alt="" style="width: 75px;">
                            </div>

                            <div class="col-md-8 text-right">
                                <div><strong>Payment Receipt</strong></div>
                                <div>Reference : <strong>#<?php echo $payment->payment_reference?></strong> </div>
                                <div>Date : <?php echo get_date($payment->entry_date, 'M/d/Y')?></div>
                            </div>
                        </div>
                    </section>
                </section>
                <?php if(isEqual($payment->payment_status, 'approved')) :?>
                    <div class="alert alert-success text-center">
                        <h1>PAYMENT APPROVED</h1>
                    </div>
                <?php else :?>
                    <div class="alert alert-danger text-center">
                        <h1>PAYMENT DENIED</h1>
                    </div>
                <?php endif?>
                <section class="customer-details mb-4">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td style="width: 40%;">Customer Name :</td>
                            <td><?php echo $payerData->firstname . ' ' .$payerData->lastname?></td>
                        </tr>
                        <tr>
                            <td>Contact</td>
                            <td><?php echo $payerData->mobile?></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td><?php echo $payerData->address?></td>
                        </tr>
                    </table>
                </section>

                <section class="particulars">
                    <h5>Particulars</h5>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <td>Description</td>
                            <td>Quantity</td>
                            <td>Amount</td>
                        </tr>

                        <tr>
                            <td><?php echo WordLib::get('cashAdvance')?> Payment for <strong>#<?php echo $loan->code?></strong></td>
                            <td>1</td>
                            <td><?php echo ui_html_amount($payment->amount)?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Total</strong></td>
                            <td><strong><?php echo ui_html_amount($payment->amount)?></strong></td>
                        </tr>
                    </table>
                </section>

                <?php echo wDivider(100)?>
                <section class="footer">
                    <div class="text-center">
                        <div><img src="<?php echo COMPANY_DETAILS['logo']?>" alt="" style="width: 45px;"></div>
                        <h6><?php echo COMPANY_DETAILS['name']?></h6>
                        <p><?php echo COMPANY_DETAILS['address']?>.</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?>
    <style>
        @media print {
            #printReciept{
                display: none;
            }
        }
    </style>
<?php endbuild()?>
<?php build('scripts')?>
    <script>
        $(document).ready(function(){
            $('#printReciept').click(function(){
                window.print();
            });
        });
    </script>
<?php endbuild()?>
<?php occupy('templates/baselayout')?>