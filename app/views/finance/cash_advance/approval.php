<?php build('content')?>
  <h3>Approved</h3>
  <table class="table">
      <thead>
          <th>Full Name</th>
          <th>Branch</th>
          <th>Amount</th>
          <th>Payment</th>
          <th>Balance</th>
          <th>Status</th>
          <th>Approved By</th>
      </thead>
       <tbody>
        
           <?php foreach($results as $row) :?>
              <tr>
                    <td><?php echo $row->fullname ?></td>
                    <td><?php echo $row->branch; ?></td>
                    <td><?php echo to_number($row->amount); ?></td>
                    <td><?php echo to_number($row->payment); ?></td>
                    <td><?php echo to_number($row->balance); ?> </td>
                    <td>
                        <h4>
                          <span class="label label-warning">
                            <?php echo $row->status?>
                          </span>
                        </h4>
                    </td>
                   <td>
                     <h4>
                       <span class="label label-info">
                         <?php echo $row->approved_by?>
                       </span>
                     </h4>
                   </td>
              </tr>
            <?php endforeach;?>
      </tbody>
  </table>
<?php endbuild()?>
<?php occupy('templates/layout')?>
