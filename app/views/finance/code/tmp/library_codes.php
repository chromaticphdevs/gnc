<h3>Code Libraries</h3>
<table class="table">
  <thead>
    <th>#</th>
    <th>Name</th>
    <th>Amount</th>
    <th title="box equivalent">BOX EQ</th>
    <th>Level</th>
    <th>DRC</th>
    <th>UNILVL</th>
    <th>BP</th>
    
    <th>Status</th>
  </thead>

  <tbody>
    <?php foreach($codeStorages as $key => $row) :?>
      <tr>
        <td><?php echo ++$key?></td>
        <td><?php echo $row->name?></td>
        <td><?php echo $row->amount?></td>
        <td title="box equivalent"><?php echo $row->box_eq?></td>
        <td><?php echo $row->level?></td>
        <td><?php echo $row->drc_amount?></td>
        <td><?php echo $row->unilevel_amount?></td>
        <td><?php echo $row->binary_point?></td> 
        <td>
          <p style="max-width: 300px;"><?php echo $row->status?></p>
        </td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>