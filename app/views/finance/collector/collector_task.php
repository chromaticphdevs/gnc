<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
    .module-container{
    }.module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px; }

table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;

  border: 1px solid #ddd;}

    th, td {
      text-align: left;
      padding: 8px;}
    tr:nth-child(even){background-color: #f2f2f2}
</style>
<?php
    $user_type = Auth::user_position();
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }
?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>

 <?php $whirlpool="831a50be987979d6ee3658eb80f2d1ca8cd21023e90cbd6a98c6c8c0801d9b263d2da6a134a128f886d4cbd22bfbd455adce86b289876df4f7b9d6945c6bbbf4"; ?>

        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->

        <div class="right_col" role="main" style="min-height: 524px;">

            <h3><?php echo $title; ?></h3>
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

                        <table class="table">
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
                                <th></th>
                            </thead>

                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($result as $data) :?>
                                      <tr>
                                        <?php $balance = ($data->amount + $data->delivery_fee ?? 0) - $data->payment['total']; ?>
                                          <?php if($data->notes == 'no_note' AND  $balance > 0):?>

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
                                            <td style="text-align: center;">
                                              <?php if($user_type =="collector" || $user_type =="customer-service-representative"):?>
                                                <a class="btn btn-success btn-sm" href="/FNProductBorrower/make_notes/?id=<?php echo seal($data->id)?>"> Make Note</a>
                                              <?php endif;?>
                                            </td>
                                        <?php endif;?> 
                                      </tr>
                                    <?php $counter++;?>
                                    <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
