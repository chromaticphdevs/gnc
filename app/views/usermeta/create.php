<?php build('content')?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add User Meta</h4>
                <a href="/FinancialStatementController/">Return</a>
            </div>

            <div class="card-body">
                <?php
                    Form::open([
                        'method' => 'post',
                        'action' => ''
                    ]);

                    Form::hidden('userid', $userid);
                ?>

                    <div class="form-group">
                        <label for="#">Category</label>
                        <select name="meta_key" id="metaKey" class="form-control">
                             <optgroup label="Income">
                                <?php foreach($this->userService::incomeKeys() as $key => $row) :?>
                                    <option value="<?php echo $row?>"><?php echo $row?></option>
                                <?php endforeach?>
                            </optgroup>

                            <optgroup label="Assets">
                                <?php foreach($this->userService::assets() as $key => $row) :?>
                                    <option value="<?php echo $row?>"><?php echo $row?></option>
                                <?php endforeach?>
                            </optgroup>

                            <optgroup label="Expenses">
                                <?php foreach($this->userService::expensesKeys() as $key => $row) :?>
                                    <option value="<?php echo $row?>"><?php echo $row?></option>
                                <?php endforeach?>
                            </optgroup>

                            <optgroup label="Liabilites">
                                <?php foreach($this->userService::liabilities() as $key => $row) :?>
                                    <option value="<?php echo $row?>"><?php echo $row?></option>
                                <?php endforeach?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Answer');
                            Form::text('meta_value', '', [
                                'class' => 'form-control',
                                'required' => true
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Describe Answer');
                            Form::textarea('meta_attribute[description]', '', [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group" id="bankName">
                        <?php
                            $bankNames['other'] = 'Others';
                            Form::label('Bank Organization');
                            Form::select('meta_attribute[bank_org]', $bankNames ,'', [
                                'class' => 'form-control',
                                'id' => 'bankNameField'
                            ]);
                        ?>
                    </div>

                    <div class="form-group" id="bankNameOther">
                        <?php
                            $bankNames['other'] = 'Others';
                            Form::label('Enter Your Bankname');
                            Form::text('bank_others','', [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php Form::submit('', 'Save Info', ['class' => 'btn btn-primary'])?>
                    </div>
                <?php Form::close()?>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
    <script>
        $(document).ready(function() {
            $("#bankName").hide();
            $("#bankNameOther").hide();

            $("#metaKey").change(function() {
                let metaKey = $("#metaKey").val();
                if(metaKey == 'Bank') {
                    $("#bankName").show();
                } else {
                    $("#bankName").hide();
                }
            });

            $("#bankNameField").change(function(){
                if($(this).val() == 'other') {
                    $("#bankNameOther").show();
                }else{
                    $("#bankNameOther").hide();
                }
            });
        });
    </script>
<?php endbuild()?>
<?php occupy('templates/layout')?>