<?php build('content')?>
<h3>Commissions</h3>

<?php $total_amount = 0 ;?>
<?php foreach($commissions as $com) : ?>
    <?php $total_amount += $com->amount?>
<?php endforeach;?>


<div class="row">
  <div class="col-md-8">
    <div class="well">

      <h3>Total Amount :<?php echo to_number($total_amount);?> </h3>
      
      <table class="table">
          <thead>
              <th>Date</th>
              <th>Username</th>
              <th>Purchaser</th>
              <th>Amount</th>
              <th>Type</th>
              <th>Company</th>
          </thead>
          <tbody>

              <?php foreach($commissions as $com) : ?>
                  <?php $total_amount += $com->amount?>
                  <tr>

                      <td><?php

                          $date=date_create($com->created_at);
                          echo date_format($date,"m/d/Y");

                          $time=date_create($com->created_at);
                          echo date_format($time," h:i A");

                      ?></td>
                      <td><?php echo $com->username?></td>
                      <td><?php echo $com->purchasername?></td>
                      <td><?php echo to_number($com->amount)?></td>
                      <td><?php echo strtoupper($com->type) ?></td>
                      <td><?php echo strtoupper($com->origin) ?></td>
                  </tr>
              <?php endforeach;?>
          </tbody>
      </table>

    </div>
  </div>

  <div class="col-md-4">
    <div class="well">
      <?php Form::open(['method' => 'get'])?>

        <?php if(Session::get('USERSESSION')['type'] == 1) :?>
        <div class="form-group">
          <?php
            /*If admin is login then */
            Form::label('User');
            Form::text('user' , '' ,[
              'class' => 'form-control',
            ]);
          ?>
        </div>
        <?php endif;?>

        <div class="form-group">
          <?php
            Form::label('Commission Type');
            Form::select('type' , $commissionTypes , 'all' , [
              'class' => 'form-control'
            ]);
          ?>
        </div>
        <div class="row form-group">
          <div class="col-md-6">
            <?php
              Form::label('Start Date');
              Form::date('start_date' , '', [
                'class' => 'form-control'
              ]);
            ?>
          </div>
          <div class="col-md-6">
            <?php
              Form::label('End Date');
              Form::date('end_date' , '', [
                'class' => 'form-control'
              ]);
            ?>
          </div>
        </div>

        <?php Form::submit('filter' , 'Apply Filter' , [
          'class' => 'btn btn-primary btn-sm'
        ])?>

        <a href="/commissions" class="btn btn-info btn-sm">Remove Filter</a>
      <?php Form::close()?>
    </div>
  </div>
</div>
</div>
<?php endbuild()?>

<?php occupy('templates/layout')?>
