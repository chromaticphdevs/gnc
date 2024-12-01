<?php build('content')?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Registered</h4>
            </div>
            <div class="card-body">
                <form action="" method="get">
                    <div>
                        <div class="row">
                            <div class="col-md-3">
                                <?php
                                    Form::label('City');
                                    Form::text('city' , '' , ['class' => 'form-control' , 'placeholder' => 'City']);
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                    Form::label('Barangay');
                                    Form::text('barangay' , '' , ['class' => 'form-control' , 'placeholder' => 'Barangay']);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <div><?php Form::label('Search Button');?></div>
                                <?php
                                    Form::submit('btnSearch' , 'Search' , ['class' => 'btn btn-primary']);
                                ?>
                                <?php if(isset( $_GET['btnSearch']) ) :?>
                                    <a href="?" class="btn btn-warning">Remove Filter</a>
                                <?php endif?>
                            </div>
                            <div class="col-md-2">
                                <?php if(isset( $_GET['btnSearch'] )) :?>
                                    
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table">
                    <table class="table table-boredered">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Date</th>
                        </thead>

                        <tbody>
                            <?php foreach( $users as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->full_name?></td>
                                    <td><?php echo $row->address?></td>
                                    <td><?php echo $row->city?></td>
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
<?php occupy('templates/raffle-baselayout')?>