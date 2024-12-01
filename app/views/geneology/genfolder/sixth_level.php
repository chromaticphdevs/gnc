<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style type="text/css">
    div.tree div.circle.user-starter{
        background: green;
    }
    div.tree div.circle.user-bronze{
        background: #5B391e;
    }
    div.tree div.circle.user-silver{
        background: #6e7a91;
    }

    div.tree div.circle.user-gold{
        background: #9A801E;
    }

    div.tree div.circle.user-platinum{
        background: #423CA2;
    }

    div.tree div.circle.user-diamond{
        background: #19759D;
    }


    div.tree div.circle.user-pre-activated
    {
        background: blue;
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
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>     
        <div class="right_col" role="main" style="min-height: 524px;">  
            <section class="x_panel">
                <section class="x_content">
                    <h3>Binary</h3>
                    <?php Flash::show()?>
                    <section id="center">
                    <div class="tree">
                        <ul>
                            <li>
                                <a href="#">
                                    <div class="circle#">
                                    </div>
                                    <div>
                                        <div><?php echo $root->username?></div>
                                        <div><?php echo 'L: '.$root->left_carry . ' '.'R: '.$root->right_carry ?></div>
                                    </div>
                                </a>
                                <ul>
                                    <!-- BASE 1 -->
                                    <li>
                                        <?php html_binary_branch($base1[0])?>
                                        <!-- BASE 2 -->
                                        <ul>
                                            <li>
                                                <?php html_binary_branch($base2[0])?>
                                                <!-- BASE 3 -->
                                                <ul>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <?php html_binary_branch($base2[1])?>
                                                <!-- BASE 3 -->
                                                <ul>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <!--// BASE 2 -->
                                    </li>

                                    <li>
                                        <?php html_binary_branch($base1[1])?>
                                        <!-- BASE 2 -->
                                        <ul>
                                            <li>
                                                <?php html_binary_branch($base2[2])?>
                                                <!-- BASE 3 -->
                                                <ul>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <?php html_binary_branch($base2[3])?>
                                                <!-- BASE 3 -->
                                                <ul>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base2[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                    <li><?php html_binary_branch($base2[0])?></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <!--// BASE 2 -->
                                    </li>
                                    <!-- // BASE 1 -->
                                </ul>
                            </li>
                        </ul>
                    </div>           
                </section>
                </section>
            </section>
        </div>
        <!-- page content -->
<script>
    $( document ).ready(function()
    {
        $('a').click(function()
        {   
            let target = $(this).attr('data-toggle');
            $(`#${target}`).toggle();
        });
    });
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>