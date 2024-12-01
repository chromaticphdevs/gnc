<?php build('content')?>
  <h4>
    <a href="?show=pending">Pending</a> |
    <a href="?show=approved">Approved</a>
  </h4>
  <h3>User Loan Requests</h3>
  <a href="/FNCashAdvance/request_list_all" class="btn btn-primary btn-sm">Return</a>
  <table class="table">
      <thead>
          <th>Full Name</th>
          <th>Branch</th>
          <th>Amount</th>
          <th>Service Fee</th>
          <th>Net</th>
          <th></th>
          <th>Status</th>
          <th>Action</th>
      </thead>
       <tbody>

           <?php foreach($results as $row) :?>
              <tr>
                  <td><?php echo $row->fullname ?></td>
                  <td><?php echo $row->branch; ?></td>
                  <td><?php echo $row->ca_amount; ?></td>
                  <form class="post" action="/FNCashAdvance/process_ca" method="post">
                    <td>
                      <?php if($row->service_fee != 0): ?>
                         <?php echo $row->service_fee; ?>
                      <?php else: ?>
                        <input type="number" name="service_fee" required>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($row->net != 0): ?>
                         <?php echo $row->net; ?>
                      <?php else: ?>
                        <input type="number" name="net" required>
                      <?php endif; ?>
                    </td>

                    <td>
                      <?php if($row->net == 0 || $row->service_fee == 0): ?>

                         <input type="hidden" name="ca_id" value="<?php echo $row->ca_id?>">
                         <input type="submit" name="" value="Process"
                         class="btn btn-success btn-sm form-confirm">

                      <?php endif; ?>
                    </td>
                  </form>
                  <td>
                      <h4>
                        <span class="label label-warning">
                          <?php echo $row->ca_status?>
                        </span>
                      </h4>
                  </td>
                 <td>
                   <form class="post" action="/FNCashAdvance/approve" method="post">
                     <input type="submit" name="" value="Approve"
                     class="btn btn-danger btn-sm form-confirm">
                     <input type="hidden" name="ca_id" value="<?php echo $row->ca_id?>">
                   </form>
                 </td>
              </tr>
            <?php endforeach;?>
      </tbody>
  </table>
<?php endbuild()?>
<?php occupy('templates/layout')?>
