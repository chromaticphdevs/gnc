
                    <div class="form-group">
                        <?php
                            Form::label('Code');
                            Form::text('code' , $code->code , ['class' => 'form-control']);
                        ?>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Upline');
                                    Form::text('upline' , '' , ['class' => 'form-control']);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                    Form::label('Direct');
                                    Form::text('direct' , '' , ['class' => 'form-control']);
                                ?>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Position');
                            Form::select('position',['LEFT' , 'RIGHT'] ,'' , ['class' => 'form-control']);
                        ?>
                    </div>
