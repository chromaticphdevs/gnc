<?php build('content') ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <?php echo wCardHeader(wCardTitle('Box of Coffee Branch Distribution'))?>
                    <div class="card-body">
                        <?php
                            Form::open([
                                'method' => 'post',
                                'action' => ''
                            ]);
                        ?>
                        <div class="form-group">
                            <?php
                                Form::label('Branch');
                                Form::select('warehouse_id', $branches , '' , [
                                    'class' => 'form-control',
                                    'required' => ''
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Quantity');
                                Form::text('quantity', '', [
                                    'class' => 'form-control',
                                    'requried' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Movement');
                                Form::select('movement', $movement , '' , [
                                    'class' => 'form-control',
                                    'required' => ''
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Price Per Item');
                                Form::text('price_per_item', $boxOfCoffeePrice, [
                                    'class' => 'form-control',
                                    'requried' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php Form::submit('' , 'Send Products')?>
                        </div>
                        <?php Form::close()?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>