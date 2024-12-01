<?php build('content')?>
<h3>Cash Inventory</h3>
<table class="table">
    <thead>
        <th>#</th>
        <th>Full Name</th>
        <th>Type</th>
        <th>Total Cash Transaction</th>

    </thead>

     <tbody>
           <?php $counter = 1;?>
           <?php foreach($result as $data) :?>
              <tr>
                    <td><?php echo $counter ?></td>
                    <td><?php echo $data->name; ?></td>
                    <td><?php echo $data->type; ?></td>
                    <td>&#8369; <?php echo to_number($data->total); ?></td>
              </tr>
            <?php $counter++;?>
            <?php endforeach;?>
    </tbody>
</table>

<?php endbuild()?>
<?php occupy('templates/layout')?>
