
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
           
            <?php Flash::show()?>
            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">

                            <section class="x_panel">
                            <section class="x_content">

                            <h3>Name: <b><?php echo $_GET['fullname']; ?> </b></h3>
                            <br>
                            <h2>Loan #: <b> <?php echo $_GET['loan_number']; ?> </b></h2>
                            <h2>Amount: <b>&#8369; <?php echo $_GET['amount']; ?> </b></h2>
                            <br>
                                <?php if(!isset($_GET['status'])):?>

                                       <a class="btn btn-success btn-sm" href="/FNProductBorrower/approve_payment/?code=<?php echo  $whirlpool.''.$whirlpool; ?>&loan_id=<?php echo $_GET['loan_id']; ?>&payment_id=<?php echo $_GET['payment_id']; ?>&userId=<?php echo $_GET['userId']; ?>&loan_number=<?php echo $_GET['loan_number']; ?>&amount=<?php echo $_GET['amount']; ?>&code2=<?php echo  $whirlpool.''.$whirlpool; ?>" id="release_product">&nbsp;Approve&nbsp;</a>

                                     &nbsp;&nbsp;&nbsp;

                                        <a class="btn btn-danger btn-sm" href="/FNProductBorrower/decline_payment/?code=<?php echo  $whirlpool.''.$whirlpool; ?>&payment_id=<?php echo $_GET['payment_id']; ?>&filename=<?php echo $_GET['filename']; ?>&code2=<?php echo  $whirlpool.''.$whirlpool; ?>" id="release_product">&nbsp;Decline&nbsp;</a>
                                        
                                <?php endif; ?>

                            <br>
                            <img style="max-height:100%; max-width:100%" src="<?php echo URL.DS.'assets/payment_image/'.$_GET['filename']; ?>" >
                            
                            </section>
                          </section>

                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>