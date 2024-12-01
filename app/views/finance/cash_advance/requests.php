<?php build('content')?>
  <h4>
    <a href="?show=pending">Pending</a> |
    <a href="?show=approved">Approved</a>
  </h4>
  <h3><?php echo ucwords($type)?></h3>


  <div class="left">
      <?php Flash::show()?>
    <form method="get">
      <div><small>Search By User Meta</small></div>
      <?php Form::text('userMeta' , '' , [
        'placeholder' => 'eg. myaccount123'
      ])?>

      <?php
        Form::submit('searchUserMeta' , ' Apply Filter ');
      ?>
      <?php if(isset($_GET['userMeta'])) :?>
        <div>
          <a href="/FNCashAdvance/request_list_all">Remove Filter</a>
        </div>
      <?php endif?>
    </form>
  </div>


  <table class="table">
      <thead>
          <th>Full Name</th>
          <th>Username</th>
          <th>Branch</th>
          <th>Amount</th>
          <th>Service Fee</th>
          <th>Net</th>
          <th></th>
          <th>Status</th>
          <?php if(isEqual($type , 'pending')): ?>
            <th>Action</th>
            <th>Show All Loans</th>
          <?php endif?>

      </thead>
       <tbody>
           <?php $prevUser = null?>
           <?php foreach($results as $row) :?>
              <?php
                if(!isEqual($prevUser, $row->username))
                {
                  $prevUser = $row->username;
                }else{
                  continue;
                }
              ?>
              <tr>
                  <td><?php echo $row->fullname ?></td>
                  <td><?php echo $row->username?></td>
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
                   <?php if(isEqual($type , 'pending') && !empty($row->service_fee)): ?>
                       <form class="post" action="/FNCashAdvance/approve" method="post">
                         <input type="submit" name="" value="Approve"
                         class="btn btn-danger btn-sm form-confirm">
                         <input type="hidden" name="ca_id" value="<?php echo $row->ca_id?>">
                       </form>
                    <?php endif;?>
                 </td>
                 <td>
                   <a href="/FNCashAdvance/showByUser/<?php echo $row->user_id?>" class="btn btn-primary btn-sm">
                     Show All
                   </a>
                 </td>
               
              </tr>
            <?php endforeach;?>
      </tbody>
  </table>
<?php endbuild()?>
<?php occupy('templates/layout')?>
