<?php build('content')?>
<h4>Loan Management</h4>
<div class="col-md-5">
  <div class="well">
    <h4>Apply Loan</h4>
    <form class="" action="/FNCashAdvanceAdmin/applyLoan" method="post">
      <input type="hidden" name="user_id" value="<?php echo $user_id?>">
      <div class="form-group">
        <label for="#">User</label>
        <input class="form-control" type="text" name="username" value="<?php echo $userInfo->username. ': '.$userInfo->fullname?>" readonly>
      </div>
      <div class="form-group">
        <label for="#">Amount</label>
        <?php Form::select('amount' , $amounts , '5000' , ['class' => 'form-control' , 'id'=>'amount']);?>
      </div>

      <div class="form-group" style="display:none">
        <label for="#">Custom Amount</label>
        <?php Form::text('custom_amount' , '' , [
          'class' => 'form-control' ,
          'id' => 'custom_amount',
        ]);?>
      </div>

      <div class="form-group">
        <?php
          Form::submit('' , 'Apply Loan' , [
            'class' => 'btn btn-primary btn-sm form-confirm',
          ]);
        ?>
        <a href="/FNCashAdvanceAdmin" class="btn btn-danger btn-sm">Cancel</a>
      </div>
    </form>
  </div>
</div>

<div class="col-md-7">
  <div class="well">
    <table class="table">
      <thead>
        <th>Amount</th>
        <th>Status</th>
        <th>Notes</th>
        <th>Action</th>
      </thead>

      <tbody>
        <?php foreach($loans as $key => $row) :?>
          <tr <?php echo strtolower($row->status) == 'approved' ? 'style="background:red; color:#fff"' : ''?>>
            <td><?php echo to_number($row->amount , 2)?></td>
            <td>
              <?php echo $row->status?>
            </td>
            <td><?php echo $row->notes?></td>
            <td>
              <?php if(strtolower($row->status) == 'pending') :?>
                <form class="" action="/FNCashAdvance/approve" method="post">
                  <input type="hidden" name="ca_id" value="<?php echo $row->id?>">
                  <input type="hidden" name="redirectTo" value="FNCashAdvanceAdmin/show?userid=<?php echo $user_id?>">

                  <input type="submit" name="" value="Approve"
                  class="btn btn-primary btn-sm form-confirm">
                </form>
              <?php endif;?>
            </td>
          </tr>
        <?php endforeach?>
      </tbody>
    </table>
  </div>
</div>
<?php endbuild()?>

<?php build('scripts')?>
<script type="text/javascript">
  $(document).ready(function(evt) {
    $("#amount").change(function(evt) {

      let value = $(this).val();

      if(value == 'others') {
        $("#custom_amount").parent().css('display' , 'block');
      }else{
        $("#custom_amount").parent().css('display' , 'none');
        $("#custom_amount").val('');
      }
    });
  });
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
