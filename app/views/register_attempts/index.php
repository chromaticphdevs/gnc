<?php build('content') ;?>

<table class="table">
    <thead>
        <th>#</th>
        <th>Fullname</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Created At</th>
    </thead>

    <tbody>
        <?php foreach($attempts as $key => $row) :?>
            <tr>
                <td><?php echo ++$key?></td>
                <td><?php echo $row->fullname?></td>
                <td><?php echo $row->email?></td>
                <td><?php echo $row->mobile?></td>
                <td><?php echo date_long($row->mobile , 'M d,Y h:i:s p')?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php endbuild();?>


<?php occupy('templates.layout')?>