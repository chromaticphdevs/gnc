<?php build('content')?>
    <div class="x_panel">
        <div class="x_content">
            <h1>Online Accounts</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>Time</th>
                    </thead>

                    <tbody>
                        <?php foreach($onlineusers as $key => $row) :?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo "$row->firstname $row->lastname"?></td>
                            <td><?php echo $row->username?></td>
                            <td><?php echo date('M d ,Y h:i:s A' ,strtotime($row->is_online))?></td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php occupy('templates.layout')?>