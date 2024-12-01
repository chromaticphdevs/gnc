<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>

    .widget
    {
        width: 150px;
        height: 150px;
        padding-top: 75px;
        text-align: center;
        border: 1px solid #000;
        display: inline-block;
    }
    .widget a{
        font-size: 1.5em;
        display: block;
    }
</style>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>   
        <div class="right_col" role="main" style="min-height: 524px;">

                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_header">
                          <ul class="nav nav-pills">
                            <li><a data-toggle="pill" href="#menu1">Branch and Account</a></li>
                            <li><a data-toggle="pill" href="#menu2">Inventories and Codes</a></li>
                            <li><a data-toggle="pill" href="#menu3">Assistance</a></li>
                            <li><a data-toggle="pill" href="#menu4">Witdraw And Deposit</a></li>
                            <li><a data-toggle="pill" href="#menu5">Code Purchase</a></li>
                          </ul>
                        </div>

                        <div class="x_content">
                            <div class="tab-content">
                            <div id="menu1" class="tab-pane active">

                                <div class="row">
                                    <div class="widget">
                                        <a href="/FNBranch/make_branch" target="_blank">Branch Management</a>
                                    </div>

                                    <div class="widget">
                                        <a href="/FNAccount/make_account" target="_blank">Account Management</a>
                                    </div>

                                    <div class="widget">
                                        <a href="/FNManager/login" target="_blank">Login as Manager</a>
                                    </div>
                                </div>

                            </div>
                            <div id="menu2" class="tab-pane fade">
                              <div class="row">
                                <div class="widget">
                                    <a href="/FNItemInventory/make_item" target="_blank">Item Management</a>
                                    <p>Single box stocks of branch</p>
                                </div>
                              
                                <div class="widget">
                                    <a href="/FNCodeInventory/make_code" target="_blank">Code Management</a>
                                    <p>Activation Codes</p>
                                </div>

                                <div class="widget">
                                    <a href="/FNCodeInventory/purchase_code" target="_blank">Code Purchase</a>
                                    <p>Purchase an activation code</p>
                                </div>

                              </div>
                              <div class="row">
                                <div class="widget">
                                    <a href="/FNSinglebox/status_list_all" target="_blank">Product Advance</a>
                                    <p>Product Advance ( Single box ) <br>Status Lists</p>
                                </div>

                              </div>

                            </div>
                            <div id="menu3" class="tab-pane fade">
                              <div class="row">

                                <div class="widget">
                                    <a href="/FNSinglebox/make_assistance" target="_blank">Request Assistance</a>
                                    <p>Request a single box assistance</p>
                                </div>

                                  <div class="widget">
                                    <a href="/FNSinglebox/claim_assistance" target="_blank">Claim</a>
                                    <p>Claim Assistance</p>
                                </div>
                              </div>
                            </div>

                            <div id="menu4" class="tab-pane fade">
                                <div class="row">
                                    <div class="widget">
                                        <a href="/FNWithdraw/make_withdraw" target="_blank">Withdraw</a>
                                        <p>Withdraw cash from branches</p>
                                    </div>
                                    <div class="widget">
                                        <a href="/FNDeposit/get_transactions" target="_blank">Deposits</a>
                                        <p>Deposit cash from branches</p>
                                    </div>
                                    <div class="widget">
                                        <a href="/FNCashInventory/get_list" target="_blank">Cash</a>
                                        <p>Cash transactions / History</p>
                                    </div>
                                </div>    
                            </div>

                            <div id="menu5" class="tab-pane fade">
                                <div class="row">
                                    <div class="widget">
                                        <a href="/FNCodeInventory/purchase_code" target="_blank">Purchase Code</a>
                                        <p>Purchase Code</p>
                                    </div>
                                    <div class="widget">
                                        <a href="/FNCodePurchase/claim_purchase" target="_blank">Claim Code</a>
                                        <p>Claim Item</p>
                                    </div>
                                </div>    
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>