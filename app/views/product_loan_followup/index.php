<?php build('content') ?>


            <h3>Released Product ( Client List )</h3>
            <?php Flash::show()?>
            <?php Flash::show('purchase_message')?>

           <?php if(Session::check('USERSESSION'))
            {

              $id=  Session::get('USERSESSION')['id'];

            }?>

             <?php 
                if(Session::check('BRANCH_MANAGERS'))
                {
                  $user = Session::get('BRANCH_MANAGERS');

                  $user_type = $user->type;
                }
                 
              ?>

            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">

                        <table class="table" id="dataTable">
                            <thead>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Loan Number</th>
                                <th>Full Name</th>
                                <th>phone</th>
                                <th>FB Link</th>
                                <th>Product Type</th>
                                <th>Amount</th>
                                <th>Delivery Fee</th>
                                <th>Payment</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </thead>

                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($clients as $data) :?>
                                      <tr>
                                        <?php $balance = ($data->amount + $data->delivery_fee ?? 0) - $data->payment['total']; ?>
                                        
                                            <td><?php echo $counter ?></td>
                                            <td>
                                              <?php
                                                  $date=date_create($data->date_time);
                                                  echo date_format($date,"M d, Y");
                                                  $time=date_create($data->date_time);
                                                  echo date_format($time," h:i A");
                                                ?>
                                            </td>
                                            <td>#<?php echo $data->code; ?></td>
                                            <td><?php echo $data->fullname; ?></td>
                                            <td><?php echo $data->mobile; ?></td>
                                            <td>
                                              <?php if($data->valid_social_media != "no_link"): ?>
                                                    <a class="btn btn-primary btn-sm" href="<?php echo $data->valid_social_media; ?>" target="_blank">Preview</a>
                                              <?php else:?>
                                                    <span class="label label-danger">No Valid FB Link</span>
                                              <?php endif;?>
                                            </td>
                                            <td><?php echo $data->product_name; ?></td>
                                            <td><?php echo $data->amount ?? 0; ?></td>
                                            <td><?php echo $data->delivery_fee ?? 0; ?></td>
                                            <td><?php echo $data->payment['total']; ?></td>
                                            <td><?php echo $balance ?></td>
                                            <td>
                                                <a href="/ProductLoanFollowUps/show/?userid=<?php echo seal($data->userid)?>&loanId=<?php echo seal($data->id)?>" class="btn btn-primary btn-sm"> Show </a>
                                            </td>
                                  
                                      </tr>
                                    <?php $counter++;?>
                                    <?php endforeach;?>
                            </tbody>
                        </table>


                      <div class="col-md-3">
                          <div class="card">
                              <div class="card-body">
                                  <h3>Archives</h3>
                                  <ul>
                                      <li> <a href="/ProductLoanFollowUps/archives" class="btn btn-danger btn-sm">Don't Follow Up</a> </li>
                                  </ul>
                                  <h3>Levels</h3>
                                  <ul class="list-group">
                                      <li class="list-group-item"><a class="btn btn-info btn-sm" href="/ProductLoanFollowUps/index?level=1"> Follow Up : 1</a></li>
                                      <?php foreach($activeLevels as $key => $row) :?> 
                                          <li class="list-group-item"><a class="btn btn-info btn-sm" href="/ProductLoanFollowUps/index?level=<?php echo $row->level?>"> Follow Up : <?php echo $row->level?></a></li>
                                      <?php endforeach?>
                                  </ul>
                              </div>
                          </div>
                      </div>
                      </div>
                      </div>
                  </div>
              </div>

<?php endbuild()?>

<?php build('scripts') ?>
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
          "pageLength": 30
        } );
    } );
</script>
<?php endbuild()?>

<?php build('headers')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<?php endbuild()?>
<?php occupy('templates/layout')?>
