<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Regular Customers'))?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Membership</th>
                        </thead>
                        <tbody>
                            <?php foreach($unilevelList as $key => $row) :?>
                                <?php if( isEqual($row->username , 'N/A') ) continue;?>
                                <tr>
                                    <td>
                                        <a href="/geneology/binary/<?php echo $row->id?>"><?php echo $row->firstname?></a>
                                    </td>
                                    <td><?php echo $row->lastname?></td>
                                    <td><?php echo $row->status?></td>
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
<?php endbuild()?>


<?php occupy('templates/layout')?>