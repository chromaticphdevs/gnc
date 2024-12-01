<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>
    .module-container
    {

    }

    .module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px;
    }


</style>
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
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->

           <!-- get user type -->
        <?php $user = Session::get('BRANCH_MANAGERS'); ?>  

        <div class="right_col" role="main" style="min-height: 524px;">
            <h3>Product Assistance</h3>
            <?php Flash::show()?>

            <?php Flash::show('code-release-error')?>

            <div class="container">
                <div class="x_panel">
                    <a href="/FNSinglebox/claim_assistance">Return</a>
                    <!-- <div class="x_well">
                        <p> <span style="color: red;">Product Assistance Requirements:</span> user must have a <strong>left and right downline</strong> </p>
                    </div> -->

                    <div class="x_content">
                        <h3>Assistance Preview</h3>

                        <div>
                            <ul>
                                <li>Customer: <?php echo $userinfo->fullname?></li>
                                <li>Username: <?php echo $userinfo->username?></li>
                                <li>Branch: <?php echo $branch->name?></li>
                            </ul>
                        </div>

                        <div style="margin-top: 10px">
                            <ul>
                                <li>Code : <?php echo $code->code?></li>
                                <li>Amount : <?php echo $code->amount?></li>
                                <li>Status : <?php echo $code->status?></li>
                            </ul>
                            <hr>

                            <?php if($code->status == 'pending' && $user->type == "stock-manager"):?>
                                <form action="/FNSingleboxClaim/do_action" method="post">
                                    <input type="hidden" name="boxid" value="<?php echo $code->id?>">
                                    <input type="submit" class="btn btn-primary btn-sm" 
                                    value="Claim" name="claim">

                                    <input type="submit" class="btn btn-primary btn-sm" 
                                    value="Claim and Pay" name="withpayment">
                                </form>
                            <?php endif;?>

                            <?php if($code->status == 'claimed' && $user->type == "cashier"):?>
                                <form action="/FNSingleboxClaim/do_action" method="post">
                                    <input type="hidden" name="boxid" value="<?php echo $code->id?>">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Pay" name="pay">
                                </form> 
                            <?php endif;?>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>