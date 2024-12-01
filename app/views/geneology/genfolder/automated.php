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
                                <?php if($userid != $root->id) :?>
                                    <div>
                                        <a href="?userid=<?php echo $root->upline?>"><h3>GO UP</h3></a>
                                    </div>
                                <?php endif?>
                                <a href="#" title="<?php echo $root->username?>">
                                    <div>
                                    <?php if(strtolower($root->status) == 'pre-activated') :?>
                                        -- --
                                    <?php else:?>
                                        <?php echo strtolower($root->status ?? '-- --')?>
                                    <?php endif?>
                                    </div>
                                    <div class="circle#">
                                    
                                    </div>
                                    <div>
                                        <div><?php echo crop_string( $root->username  , 5) ?? 'no user'?></div>
                                        <div><?php echo 'L: '.$root->left_carry . ' '.'R: '.$root->right_carry ?></div>
                                    </div>
                                </a>
                                <ul>
                                    <?php 

                                        $sw = [
                                            'base1' => 0,
                                            'base2' => 0,
                                            'base3' => 0,
                                            'base4' => 0,
                                            'base5' => 0,
                                            'base6' => 0,
                                            'base7' => 0,
                                            'base8' => 0,
                                            'base9' => 0
                                        ];
                                    ?>
                                    <?php $b1 = 0?>
                                    <?php $b2 = 0?>

                                    <?php while($b1 < ($sw['base1'] + 2) && $sw['base1'] < count($base1)) :?>
                                        <li>
                                            <?php html_binary_branch($base1[$b1])?>
                                            <ul>
                                                <?php while($b2 < ($sw['base2'] + 2) && $sw['base2'] < count($base2)) : ?>
                                                    <li>
                                                        <?php html_binary_branch($base2[$b2])?>
                                                    </li>
                                                    <?php $b2++?>
                                                <?php endwhile?>
                                                <?php $sw['base2'] = $b2?>
                                            </ul>
                                        </li>
                                        <?php $b1++?>
                                    <?php endwhile?>
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