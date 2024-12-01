<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('BOX OF COFFEE LOAN'))?>
            <div class="card-body">
                <a href="/LoanController/">Loans</a>
                <form action="" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Branch');
                                    Form::select('branch_id', $branches, '', ['class' => 'form-control'])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    Form::label('Date');
                                    Form::date('date', '', ['class' => 'form-control'])
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php
                            Form::label('User');
                            Form::select('user_id', arr_layout_keypair($users, 'id', 'fullname'), '', ['class' => 'form-control','id'=>'userId'])
                        ?>
                    </div>
                    

                    <div class="form-group" id="quantityContainer">
                        <?php
                            Form::label('Quantity');
                            Form::text('quantity','',['class' => 'form-control','id'=>'quantity']);
                        ?>
                    </div>

                    <div class="form-group" id="submitContainer">
                        <?php
                            Form::submit('','Save Loan',['id' => 'loanSubmit']);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            $("#quantityContainer").hide();
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
                        $("#quantityContainer").show();
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