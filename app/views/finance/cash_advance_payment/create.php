<?php build('templates/layout')?>
  <?php Form::open(['method' => 'post' , 'action' => '/FNCashAdvancePayment/store'])?>
  <div class="form-group">
    <?php Form::label('Balance')?>
    <?php Form::input('balance' , $loan->balance , [
        'class' => 'form-control',
        'id'    => 'balance',
        'readonly' => ''
      ])?>
  </div>
  <?php Form::close()?>
<?php endbuild()?>
