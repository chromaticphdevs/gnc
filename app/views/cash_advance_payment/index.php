<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonRight('', [
            $navigationHelper->setnav('', 'Add Payment', '/CashAdvancePaymentController/search')
        ])?>
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Payments')) ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" placeholder="search payment..." id="keywordsearch">
                    </div>

                    <div class="col-md-6 text-right">
                        <?php if(!empty($req['btn_filter']) || !empty($req['btn_search_reference'])) :?>
                            <a href="/CashAdvancePaymentController" class="btn btn-warning btn-sm"><i class="fa fa-times"></i></a>
                        <?php endif?>

                        <?php if(!empty($req['loan_reference'])) :?>
                            <a title="approve all payments" href="/CashAdvancePaymentController/approveAll/?q=<?php echo seal($req)?>" 
                                class="btn btn-success btn-sm form-confirm"><i class="fa fa-check"></i></a>
                        <?php endif?>
                        
                        <?php if(isEqual($req['status'] ?? '', 'for approval') && count($payments) > 0) :?>
                            <a href="/CashAdvancePaymentController/approveAll?q=<?php echo seal($req)?>" class="btn btn-primary btn-sm">Approve All</a>
                        <?php endif?>

                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-filter"></i></button>
                    </div>
                </div>
                <?php Flash::show() ?>
                <div>Total Results : <?php echo $paymentTotalCount ?></div>

                <div class="table-responsive mt-3">
                    <?php $totalAmount = 0?>
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Loan Reference</th>
                            <th>External Reference</th>
                            <th>Borrower Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </thead>

                        <tbody id="tableRows">
                            <?php foreach($payments as $key => $row) :?>
                                <?php $totalAmount += $row->amount?>
                                <tr data-id="<?php echo seal($row->id)?>">
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->payment_reference?></td>
                                    <td><?php echo $row->loan_reference?></td>
                                    <td><?php echo $row->external_reference?></td>
                                    <td><?php echo $row->payer_fullname?></td>
                                    <td><?php echo ui_html_amount($row->amount)?></td>
                                    <td><?php echo $row->entry_date?></td>
                                    <td><?php echo wTruOrFalseText(isEqual($row->payment_status, 'approved'), ['Approved', $row->payment_status], ['#1cc88a', '#f6c23e']) ?></td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                    <h4>Total Amount : <span id="totalAmount"><?php echo ui_html_amount($totalAmount)?></span> </h4>
                </div>
                <?php if(!empty($pagination['totalPaymentCount'])) :?>
                    <?php echo wPaginator($pagination['totalPaymentCount'],$pagination['itemsPerPage'], 'CashAdvancePaymentController:index', $req)?>
                <?php endif?>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payments Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    Form::open([
                        'method' => 'get'
                    ])
                ?>
                    <div class="form-group">
                        <?php
                            Form::label('Loan Reference (optional)');
                            Form::text('loan_reference', '', [
                                'class' => 'form-control'
                            ])
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Start Date');
                            Form::date('start_date','', [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('End Date');
                            Form::date('end_date','', [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Status');
                            Form::select('status',[
                                'approved', 'for approval', 'denied'
                            ],'', [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Display');
                            Form::select('display',[
                                'show_all' => 'Show All',
                                'limit'    => 'Limit Result'
                            ],'', [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php Form::submit('btn_filter', 'Apply Filter', [
                            'class' => 'btn btn-primary btn-sm'
                        ])?>
                    </div>
                <?php Form::close()?>
            </div>
            </div>
        </div>
    </div>
<?php endbuild() ?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            var totalAmount = 0;
            $('table').on('dblclick', '#tableRows tr', function(){
                let dataId = $(this).data('id');

                if(typeof dataId == 'undefined') {
                    return;
                }

                window.location.href = '/CashAdvancePaymentController/show/' + dataId;
            });

            $('#keywordsearch').on('keyup', function(e){
                let keyword = $(this).val();

                $.ajax({
                    url  : '/CashAdvancePaymentController/api_fetch_all',
                    type : 'GET',
                    data : {
                        keyword : keyword
                    },
                    success : function(response) {
                        response = JSON.parse(response);
                        let responseData = response['data'];
                        $("#tableRows").html(tableBuilder(responseData['payments']));
                        reDrawAmount(totalAmount);
                    }
                });
            });

            function tableBuilder(rows) {
                let retVal = '';
                totalAmount = 0;
                if(rows) {
                    let counter = 1;
                    for(let i in rows) {
                        let row = rows[i];
                        totalAmount += Number(row['amount']);
                        retVal += `
                            <tr data-id="${row['id_sealed']}">
                                <td>${counter}</td>
                                <td>${row['payment_reference']}</td>
                                <td>${row['loan_reference']}</td>
                                <td>${row['external_reference']}</td>
                                <td>${row['payer_fullname']}</td>
                                <td>${row['amount_text']}</td>
                                <td>${row['entry_date']}</td>
                                <td>${row['payment_status']}</td>
                            </tr>
                        `;
                        counter++;
                    }
                }
                return retVal;
            }

            function reDrawAmount(totalAmount) {
                let amounText = formatMoney(totalAmount, 2)
                $('#totalAmount').html(amounText);
            }
        }); 
    </script>
<?php endbuild()?>
<?php occupy() ?>