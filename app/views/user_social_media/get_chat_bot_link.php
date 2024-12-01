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
    table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
    }
    th, td {
      text-align: left;
      padding: 8px;
    }
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
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">
 
            <?php Flash::show()?>
            <div class="container">
                <div class="x_panel">

                   
                    <?php if(!empty($result)): ?>
                      <br><br>
                           <h2> <span id="r2">
                              <?php echo $result->chat_bot_link; ?>
                            </span> </h2>
                              &nbsp;&nbsp;&nbsp; <br><br>
                                <button onclick="copyToClipboard('#r2')" class="btn btn-success btn-sm">Copy Chat Bot Link</button>

                                &nbsp;&nbsp;&nbsp; <br><br><br>
                                <a  class="btn btn-success btn-sm" role="button" href="<?php echo $result->chat_bot_link; ?>" target="_blank">Open Chat Bot Link</a>
                                <script>
                                    function copyToClipboard(element) {
                                        var $temp = $("<input>");
                                        $("body").append($temp);
                                        $temp.val($(element).text()).select();
                                        document.execCommand("copy");
                                        $temp.remove();
                                    }
                                </script>

                          <!--<a class="btn btn-success btn-sm" href="<?php echo $result->chat_bot_link; ?>" >&nbsp;Chat Bot Link&nbsp;</a>-->
                    <?php else:?>
                            <h1>NO Chat Bot Link</h1>
                    <?php endif;?>
        
    
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>