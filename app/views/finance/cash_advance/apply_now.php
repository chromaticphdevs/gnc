<?php build('content')?>
  <?php if(empty($_GET['view'])) :?>
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Loans</h4>
        <a href="?view=new" class="btn btn-primary btn-sm">Apply Now</a>
        <a href="/CashAdvance/notifications" class="btn btn-primary btn-sm">Notifications</a>
        <a href="/CashAdvance/coborrower" class="btn btn-primary btn-sm">Co-Borrowing</a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Reference</th>
              <th>Loan Amount</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action Show</th>
            </thead>

            <tbody>
              <?php foreach($loans as $key => $row)  :?>
                <tr>
                  <td><?php echo ++$key?></td>
                  <td><?php echo $row->code?></td>
                  <td><?php echo ui_html_amount($row->amount)?></td>
                  <td><?php echo $row->status?></td>
                  <td><?php echo $row->created_on?></td>
                  <td><a href="/CashAdvance/loan/<?php echo seal($row->id)?>">Show</a></td>
                </tr>
              <?php endforeach?>
            </tbody>
          </table>
        </div>
          <!-- -->
      </div>
    </div>
  <?php else :?>
    <a href="/FNCashAdvance/apply_now" class="btn btn-primary btn-sm">Loan List</a>
    <?php 
      $curAmount = 1000;
      $userId = seal(whoIs()['id']);
    ?>
    <?php for($i = 0; $i < 13 ; $i++):?>
    <div class="col-xs-12">
        <div class="tile-stats">
            <div class="icon green"><i class="fa fa-credit-card"></i> </div>
            <div class=" text-center">
              <h5>&nbsp;&nbsp;&nbsp; Cash Advance</h5>
              <?php if($curAmount > 320000) :?>
                <h1><?php echo number_format(1000000, 2)?></h1>
                <?php break?>
              <?php else:?>
                <h1><?php echo number_format($curAmount, 2)?></h1>
              <?php endif?>
              <?php
                $amount = seal($curAmount);
                $href = "/CashAdvance/agreement?amount={$amount}==&userId={$userId}";
              ?>
              <a class="btn btn-success btn-sm" href="<?php echo $href?>">Apply Now</a>
            </div>
        </div>
    </div>
    <?php
      if ($curAmount >= 5000) {
        $curAmount *= 2;
      }else{
        $curAmount += 1000;
      }
    ?>
    <?php endfor?>
  <?php endif?>
<?php endbuild()?>
<?php occupy('templates/layout')?>
