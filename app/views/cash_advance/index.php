<?php build('content') ?>
<div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Loans')) ?>
        <div class="card-body">
            <?php Flash::show() ?>
            <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) :?>
                <input type="text" placeholder="search loan.." id="keywordsearch">
            <?php endif?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Mobile Number</th>
                        <th><?php echo WordLib::get('directSponsor')?></th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>

                    <tbody id="cashAdvanceRows">
                        <?php $totalBalance = 0?>
                        <?php foreach($loans as $key => $row) :?>
                            <?php $totalBalance += $row->ca_balance?>
                            <tr data-id="<?php echo seal($row->ca_id)?>">
                                <td><?php echo ++$key?></td>
                                <?php if(isEqual(whoIs('type'), USER_TYPES['MEMBER'])) :?>
                                    <td><a href="/CashAdvance/loan/<?php echo seal($row->ca_id)?>"><?php echo $row->ca_reference?></a></td>
                                <?php else :?>
                                    <td><?php echo $row->ca_reference?></td>
                                <?php endif?>
                                <td><?php echo $row->fullname?></td>
                                <td><?php echo $row->username?></td>
                                <td><?php echo $row->mobile_number?></td>
                                <td><?php echo $row->direct_sponsor_name?></td>
                                <td><?php echo ui_html_amount($row->ca_amount)?></td>
                                <td><?php echo ui_html_amount($row->ca_balance)?></td>
                                <td><?php echo $row->ca_date?></td>
                                <td><?php echo $row->ca_status?></td>
                                <td>
                                    <a href="/FNCashAdvance/release/<?php echo seal($row->ca_id)?>">Release</a>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <?php echo wPaginator($pagination['totalItemCount'], $pagination['itemsPerPage'], 'FNCashAdvance:index')?>
            <hr>
            <h4>Total Balance : <?php echo ui_html_amount($totalBalance)?> </h4>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function() {

            if($('#keywordsearch')) {
                $('#keywordsearch').on('keyup', function(){
                    let keyword = $(this).val();

                    if(keyword.length > 1) {
                        $.ajax({
                            type : 'GET',
                            url : '/FNCashAdvance/api_fetch_all',
                            data : {
                                keyword : keyword
                            },
                            success : function(response) {
                                response = JSON.parse(response);
                                let responseData = response.data;
                                $('#cashAdvanceRows').html(tableBuilder(responseData['loans']));
                            }
                        })
                    } else if(keyword == '') {
                        $.ajax({
                            type : 'GET',
                            url : '/FNCashAdvance/api_fetch_all',
                            data : {
                                keyword : keyword
                            },
                            success : function(response) {
                                response = JSON.parse(response);
                                let responseData = response.data;
                                $('#cashAdvanceRows').html(tableBuilder(responseData['loans']));
                            }
                        })
                    }
                });
            }

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
                        <tr data-id='${rowData['id_sealed']}'>
                            <td>${counter}</td>
                            <td>${rowData['ca_reference']}</td>
                            <td>${rowData['fullname']}</td>
                            <td>${rowData['username']}</td>
                            <td>${rowData['mobile_number']}</td>
                            <td>${rowData['direct_sponsor_name']}</td>
                            <td>${rowData['txt_amount']}</td>
                            <td>${rowData['txt_balance']}</td>
                            <td>${rowData['ca_date']}</td>
                            <td>${rowData['ca_status']}</td>
                            <td><a href='/FNCashAdvance/release/${rowData['id_sealed']}'>Release</a></td>
                        </tr>
                    `;
                    counter++;
                }
                return retVal;
            }
        });
    </script>
<?php endbuild() ?>
<?php occupy('templates/layout')?>