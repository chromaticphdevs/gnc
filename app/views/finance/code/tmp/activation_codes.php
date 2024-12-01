<h3>Activation Codes</h3>
<table class="table">
  <thead>
    <th>#</th>
    <th>Branch</th>
    <th>Code</th>
    <th>Amount</th>
    <th>BOX EQ</th>
    <th>Level</th>
    <th>DRC</th>
    <th>UNILVL</th>
    <th>BP</th>
    <th>COMP</th>
    <th>Status</th>
  </thead>

  <tbody>
    <?php foreach($codes as $key => $row) :?>
      <tr>
        <td><?php echo ++$key?></td>
        <td><?php echo $row->branch_name?></td>
        <td><?php echo $row->code?></td>
        <td><?php echo $row->amount?></td>
        <td><?php echo $row->box_eq?></td>
        <td><?php echo $row->level?></td>
        <td><?php echo $row->drc_amount?></td>
        <td><?php echo $row->unilevel_amount?></td>
        <td><?php echo $row->binary_point?></td>
        
        <td><?php echo $row->company?></td>
        <td>
          <p style="max-width: 300px;"><?php echo $row->status?></p>
        </td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>