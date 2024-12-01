<?php build('content')?>
<h3><?php echo $title?></h3>
<div class="row">
  <div class="col-md-8">
    <div class="well">
      <?php if(strtolower($pageTable)  == 'payout'):?>

      <?php if(!empty($forPayout['list'])):?>
      <table class="table">
          <thead>
              <th>#</th>
              <th>Username</th>
              <th>Name</th>
              <th>Amount Payout</th>
          </thead>
          <tbody>
              <?php foreach($forPayout['list'] as $key => $payout) :?>
                  <tr>
                      <td><?php echo ++$key?></td>
                      <td><?php echo $payout->username?></td>
                      <td><?php echo $payout->fullname?></td>
                      <td><?php echo to_number($payout->amount)?></td>
                  </tr>
              <?php endforeach;?>
          </tbody>
      </table>
    <?php else:?>
      <h1>No Payouts as of <?php echo date('M d ,Y' , strtotime( today() )) ?></h1>
    <?php endif;?>
    <?php endif;?>

    <?php
      if(strtolower($pageTable) == 'pay-in')
        grab('mgpayout/pay_ins' , $data);
    ?>
    </div>
  </div>

  <div class="col-md-4">
    <div class="well">
      <?php Form::open(['action'=>'/MGPayout/createPayout' , 'method' => 'post'])?>
        <div class="form-group">
          <h4>Total Payout</h4>
          <div class=" row">
            <div class="col-md-8">
              <label for="#">Total</label>
              <input type="text" value="<?php echo to_number($forPayout['total'])?>"
              class="form-control" readonly>
            </div>

            <div class="col-md-4">
              <label for="#">Percentage</label>
              <input type="text" value="<?php echo $payoutPercentage ??0 .'%'?>"
              class="form-control" readonly>
            </div>
          </div>
        </div>

        <div class="form-group">
            <h4>Total Payin</h4>
            <input type="text" name="" value="<?php echo to_number($payins['total'] ?? 0)?>"
            class="form-control" readonly>
            <?php if(!empty($payins['list'])):?>
            <a href="?content=payin">Show me payin-list</a>
            <?php endif;?>
        </div>
        <div class="form-group">
          <h4>Payout Period</h4>
          <?php $payoutPeriod= date('M d ,Y h:i:s a' , strtotime($forPayout['details']->dateend ?? today()))?>
          <input type="text" value="<?php echo $payoutPeriod . ' to '. date('M d, Y h:i:s a') ?>"
          class="form-control" readonly>
          <strong>
            <small>Previous Payout Period: <?php echo date('M d,Y h:i:s a', strtotime($forPayout['details']->datestart ?? today()))?> To
            <?php echo date('M d,Y h:i:s a', strtotime($forPayout['details']->dateend ?? today()))?></small>
          </strong>
        </div>
        <?php Form::submit('create_payout' , 'Create Payout' , ['class' =>'btn btn-danger btn-sm form-confirm'])?>
        <?php Form::submit('export_payout' , 'Export As Excell' , ['class' =>'btn btn-primary btn-sm' , 'form' => 'export_excel_form'])?>
      <?php Form::close()?>

      <?php
        Form::open(['method' => 'post' , 'action' => '/MGPayout/exportExcel' , 'id' => 'export_excel_form' , 'name' => 'export_excel_form']);
        Form::hidden('users' , base64_encode(serialize($forPayout['list'])));
        Form::close();
      ?>
    </div>
  </div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>
