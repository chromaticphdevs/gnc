<?php build('content') ?>
<div class="container-fluid">
    <?php echo wControlButtonRight('', [
        $navigationHelper->setnav('', 'Active', '/CashAdvanceReleaseController/index', [
            'icon' => 'fa fa-list'
        ]),

        $navigationHelper->setnav('', 'Paid', '/CashAdvanceReleaseController/index?status=paid', [
            'icon' => 'fa fa-list'
        ]),

        $navigationHelper->setnav('', 'Past Due', '/CashAdvanceReleaseController/pastdue', [
            'icon' => 'fa fa-list'
        ]),
    ])?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Cash Advance Releases')) ?>
        <div class="card-body">
            <?php Flash::show()?>
            <?php if(!empty($req['status']) && $req['status'] == 'paid') :?>
                <h3 class="text-success">Paid</h3>
            <?php endif?>
            <div class="row mb-2">
                <div class="col-md-6">
                    <input type="text" placeholder="search here.." id="keywordsearch">
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-primary btn-sm" 
                        data-toggle="modal" 
                        data-target="#modalFilter"><i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>
            <div>Total Results : <?php echo $pagination['totalItemCount'] ?></div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Rereference</th>
                        <th>Borrower name</th>
                        <th>Borrower username</th>
                        <th>Loan Reference</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Initial Balance</th>
                        <th>Balance</th>
                        <th>Release Date</th>
                    </thead>

                    <tbody id="releaseRows">
                        <?php $totalAmount = 0?>
                        <?php foreach($cash_advance_releases as $key => $row) :?>
                            <?php $totalAmount += $row->amount?>
                            <tr data-id="<?php echo $row->id?>">
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->release_reference?></td>
                                <td><?php echo $row->member_name?></td>
                                <td><?php echo $row->username?></td>
                                <td><?php echo $row->loan_reference?></td>
                                <td><?php echo $row->loan_status?></td>
                                <td><?php echo $row->amount?></td>
                                <td><?php echo $row->loan_net?></td>
                                <td><?php echo $row->loan_balance?></td>
                                <td><?php echo $row->entry_date?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <h4>Total Amount : <?php echo ui_html_amount($totalAmount)?></h4>
            
            <?php
                if(isEqual($req['display'] ?? '', 'limit')) {
                    echo wPaginator($pagination['totalItemCount'], $pagination['itemsPerPage'], 'CashAdvanceReleaseController:index', $req);
                }
            ?>
        </div>
    </div>

    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFilterLabel">Cash Advance Release Filter</h5>
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
                            Form::label('By user');
                            Form::text('username','', [
                                'class' => 'form-control',
                                'placeholder' => 'type in username eg. testusera, testuserb'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Status');
                            Form::select('status',[
                                'Paid', 'Active'
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
</div>
<?php endbuild() ?>

<?php build('scripts')?>
    <script>
        $(document).ready(function() {
            $('table').on('dblclick','#releaseRows tr',function(event){
                let dataId = $(this).data('id');
                return window.location.href = '/CashAdvanceReleaseController/show/'+dataId;
            });

            $("#keywordsearch").on('keyup', function(){
                let keyword = $(this).val();

                if(keyword.length > 1) {
                    $.ajax({
                        type : 'GET',
                        url : '/CashAdvanceReleaseController/api_fetch_all',
                        data : {
                            keyword : keyword
                        },
                        success : function(response) {
                            response = JSON.parse(response);
                            let responseData = response['data'];
                            $('#releaseRows').html(tableBuilder(responseData['releases']));
                        }
                    });

                } else {
                    $.ajax({
                        type : 'GET',
                        url : '/CashAdvanceReleaseController/api_fetch_all',
                        data : {
                            keyword : keyword
                        },
                        success : function(response) {
                            response = JSON.parse(response);
                            let responseData = response['data'];
                            $('#releaseRows').html(tableBuilder(responseData['releases']));
                        }
                    });
                }
            });

            /**returns html text data */
            function tableBuilder(rows) {
                if(!rows) {
                    return;
                }
                let counter = 1;
                let retVal = '';

                for(let i in rows) {
                    let rowData = rows[i];
                    retVal += `
                        <tr data-id='${rowData['id']}'>
                            <td>${counter}</td>
                            <td>${rowData['release_reference']}</td>
                            <td>${rowData['member_name']}</td>
                            <td>${rowData['username']}</td>
                            <td>${rowData['loan_reference']}</td>
                            <td>${rowData['loan_status']}</td>
                            <td>${rowData['amount']}</td>
                            <td>${rowData['loan_net']}</td>
                            <td>${rowData['loan_balance']}</td>
                            <td>${rowData['entry_date']}</td>
                        </tr>
                    `;
                    counter++;
                }
                return retVal;
            }
        });
    </script>
<?php endbuild()?>

<?php occupy()?>