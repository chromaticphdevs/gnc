<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonLeft('', [
            $navigationHelper->setNav('', 'Debtors', 'LoanController/debtors'),
            $navigationHelper->setNav('', 'Loan', 'LoanController/boxOfCoffee'),
            $navigationHelper->setNav('', 'Payment', 'LoanController/payment'),
        ])?>
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loan Payment'))?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>User</th>
                            <th>Branch</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Entry Type</th>
                            <th>Created At</th>
                        </thead>
                        
                        <tbody>
                            <?php foreach($payments as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->fullname?></td>
                                    <td><?php echo $row->parent_id?></td>
                                    <td><?php echo $row->entry_date?></td>
                                    <td><?php echo $row->amount?></td>
                                    <td><?php echo $row->entry_type?></td>
                                    <td><?php echo $row->created_at?></td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            $("#amountContainer").hide();
            $("#submitContainer").hide();

            $("#userId").change(function()
            {
                let userId = $("#userId").val();

                $.ajax({
                    url : get_url('API_Loan/getBoxOfCoffeeCreditLimit/'+userId),
                    method : 'GET',
                    success : function(response) {
                        
                        response = JSON.parse(response);
                        let responseData = response.data;

                        $("#quantity").val(responseData);
                        $("#amountContainer").show();
                        $("#submitContainer").show();
                    }
                })
            });
        });
    </script>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>