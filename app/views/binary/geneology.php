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
            <!-- profile quick info -->
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
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

        <!-- page content -->       
        <div class="right_col" role="main" style="min-height: 524px;">  
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"><div class=" flash_message" id="message" style="display: none;"></div>   <script>
                    setTimeout(function() {
                        $('#message').fadeOut('slow');
                    }, 3000);
                </script>
                </div>                  
            </div>
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?>


            
            <section id="center">
                <?php include_once(VIEWS.DS.'templates/content/tree_2.php')?>
            </section> 

             <?php
                $on_tree = array();

                foreach($geneology as $res)
                {
                    if(!empty($res->id)){
                        array_push($on_tree, $res->id);
                    }
                    
                }
            ?>
            <?php if(!empty($tree)):?>
                <table class="table">
                <thead>
                    <th>User ID</th>
                    <th>User</th>
                    <th>Upline</th>
                    <th>Your Position</th>
                    <th>Date</th>
                    <th>New Upline</th>
                </thead>

                <tbody>
                    <?php $level = 1; ?>
                    <?php 
                        $newleft  = $left;
                        $newright = $right;
                    ?>
                    <?php foreach($tree as $user_tree) :?>
                        <?php if(is_array($user_tree)) : ?>
                            <tr>
                                <td colspan="4">
                                    <h1><?php echo "TREE LEVEL : {$level}"?></h1>
                                </td>
                            </tr>
                            <?php foreach($user_tree as $user):?>
                                <?php if( in_array($user->id, $on_tree) ){
                                    continue;
                                } ?>

                                <tr>
                                    <td><?php echo $user->id;?></td>
                                    <td><?php echo $user->username?></td>
                                    <td><?php echo $user->upline?></td>
                                    <td><?php echo $user->L_R?></td>
                                    <td><?php echo $user->created_at?></td>
                                    <td>
                                        <?php

                                            $link_left = URL.DS.'geneology/update/?userid='.$user->id.'&newupline='.$newleft;
                                            $link_right = URL.DS.'geneology/update/?userid='.$user->id.'&newupline='.$newright;
                                        ?>
                                        <?php if(strtoupper($user->L_R) == 'LEFT') :?>
                                            <a href="<?php echo $link_left?>">
                                                New Upline (<?php echo $newleft?>)
                                            </a>
                                        <?php else:?>
                                            <a href="<?php echo $link_right?>">
                                                New Upline (<?php echo $newright?>)
                                            </a>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            <?php $level++;?>
                        <?php endif;?>
                    <?php endforeach;?>
                </tbody>
                </table>
            <?php endif;?>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>