<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Payin'))?>
            <div class="card-body">
                <?php Flash::show()?>
                <form action="/MGPayout2/get_payins_with_option" method="post">
                    <select name="days">
                        <option value="today">Today</option>
                        <option value="days7">Week</option>
                        <option value="days30">Month</option>
                        <option value="days90">90 days</option>
                        <option value="days180">6 Month</option> 
                    </select>
                    <input type="submit" class="btn btn-success btn-sm" value="Show">
                </form>
                <div class="col-md-12">
                    <?php if(isset($payins) &&!empty($payins)) :?>
                        <h3>Total Payin : <?php echo to_number($payins['total'])?></h3>
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable">
                                <thead>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Origin</th>
                                    <th>Date and time</th>
                                </thead>

                                <tbody>
                                    <?php foreach($payins['list'] as $key => $row) :?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->amount?></td>
                                            <td><?php echo $row->type?></td>
                                            <td><?php echo $row->origin?></td>
                                            <td><?php echo $row->dateandtime?></td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<script defer>
    $( document ).ready(function() {

    $("#payout").on('submit' , function(e)
    {
        if (confirm("Are You Sure?")) 
        {
            return true;
        }else
        {
            return false;
        }
    });

    });
</script>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>