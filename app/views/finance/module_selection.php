<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>
    .module-container
    {
        display: flex;
        flex-direction: row;
        margin: 20px;
        padding: 10px;
    }

    .module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px;
        margin: 20px;
    }
    
    .module-container .module a
    {
        font-size:20px;
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
            <h1>MODULE SELECTION</h1>


            <div class="module-container">
                <div class="module">
                    <h3>Branch Management</h3>
                    <ul>
                        <li><a href="/FNBranch/make_branch" target="_blank">Create Branch</a></li>
                        <li><a href="/FNAccount/make_account" target="_blank">Create Account</a></li>
                        <li><a href="/FNManager/login" target="_blank">Login as Manager</a></li>
                    </ul>
                </div>

                <div class="module">
                    <h3>Inventory Management</h3>
                    <ul>
                        <li><a href="/FNItemInventory/make_item" target="_blank">Item Inventory</a></li>
                        <li><a href="/FNCashInventory/get_list" target="_blank">Cash Inventory</a></li>
                        <li><a href="/FNCodeInventory/make_code" target="_blank">Code Inventory</a></li>
                    </ul>
                </div>


                <div class="module">
                    <h3>Singlebox</h3>
                    <ul>
                        <li><a href="/FNSinglebox/make_assistance" target="_blank">Request Assistance</a></li>
                        <li><a href="/FNSinglebox/claim_assistance" target="_blank">View Request Assistances</a></li>
                    </ul>
                </div>


                <div class="module">
                    <h3>Withdraw And Deposit</h3>
                    <ul>
                        <li><a href="/FNWithdraw/make_assistance" target="_blank">Withdraw</a></li>
                        <li><a href="/FNDeposit/get_transactions" target="_blank">Deposits</a></li>
                    </ul>
                </div>

            </div>
            <?php Flash::show()?>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>