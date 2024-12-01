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
                                                        <?php html_binary_branch($base3[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[0])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[0])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[0])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[0])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[0])?></li>
                                                                                            <li><?php html_binary_branch($base8[1])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[1])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[2])?></li>
                                                                                            <li><?php html_binary_branch($base8[3])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[1])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[2])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[4])?></li>
                                                                                            <li><?php html_binary_branch($base8[5])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[3])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[6])?></li>
                                                                                            <li><?php html_binary_branch($base8[7])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[1])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[2])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[4])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[8])?></li>
                                                                                            <li><?php html_binary_branch($base8[9])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[5])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[10])?></li>
                                                                                            <li><?php html_binary_branch($base8[11])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[3])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[6])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[12])?></li>
                                                                                            <li><?php html_binary_branch($base8[13])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[7])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[14])?></li>
                                                                                            <li><?php html_binary_branch($base8[15])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[1])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[2])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[4])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[8])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[16])?></li>
                                                                                            <li><?php html_binary_branch($base8[17])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li><?php html_binary_branch($base7[9])?></li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[5])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[10])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[18])?></li>
                                                                                            <li><?php html_binary_branch($base8[19])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[11])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[20])?></li>
                                                                                            <li><?php html_binary_branch($base8[21])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[3])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[6])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[12])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[22])?></li>
                                                                                            <li><?php html_binary_branch($base8[23])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[13])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[24])?></li>
                                                                                            <li><?php html_binary_branch($base8[25])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[7])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[14])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[26])?></li>
                                                                                            <li><?php html_binary_branch($base8[27])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[15])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[28])?></li>
                                                                                            <li><?php html_binary_branch($base8[29])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base3[1])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[2])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[4])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[8])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[16])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[30])?></li>
                                                                                            <li><?php html_binary_branch($base8[31])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[17])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[32])?></li>
                                                                                            <li><?php html_binary_branch($base8[33])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[9])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[18])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[34])?></li>
                                                                                            <li><?php html_binary_branch($base8[35])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[19])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[36])?></li>
                                                                                            <li><?php html_binary_branch($base8[37])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[5])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[10])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[20])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[38])?></li>
                                                                                            <li><?php html_binary_branch($base8[39])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[21])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[40])?></li>
                                                                                            <li><?php html_binary_branch($base8[41])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[11])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[22])?>
                                                                                         <!-- BASE 8 -->
                                                                                         <ul>
                                                                                            <li><?php html_binary_branch($base8[42])?></li>
                                                                                            <li><?php html_binary_branch($base8[43])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[23])?>
                                                                                         <!-- BASE 8 -->
                                                                                         <ul>
                                                                                            <li><?php html_binary_branch($base8[44])?></li>
                                                                                            <li><?php html_binary_branch($base8[45])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[3])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[6])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[12])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[24])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[46])?></li>
                                                                                            <li><?php html_binary_branch($base8[47])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[25])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[48])?></li>
                                                                                            <li><?php html_binary_branch($base8[49])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[13])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[26])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[50])?></li>
                                                                                            <li><?php html_binary_branch($base8[51])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[27])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[52])?></li>
                                                                                            <li><?php html_binary_branch($base8[53])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[7])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[14])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[28])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[54])?></li>
                                                                                            <li><?php html_binary_branch($base8[55])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[29])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[56])?></li>
                                                                                            <li><?php html_binary_branch($base8[57])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[15])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[30])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[58])?></li>
                                                                                            <li><?php html_binary_branch($base8[59])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[31])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[60])?></li>
                                                                                            <li><?php html_binary_branch($base8[61])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
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
                                                        <?php html_binary_branch($base3[2])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[4])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[8])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[16])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[32])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[62])?></li>
                                                                                            <li><?php html_binary_branch($base8[63])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[33])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[64])?></li>
                                                                                            <li><?php html_binary_branch($base8[65])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[17])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[34])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[66])?></li>
                                                                                            <li><?php html_binary_branch($base8[67])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[35])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[68])?></li>
                                                                                            <li><?php html_binary_branch($base8[69])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[9])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[18])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[36])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[70])?></li>
                                                                                            <li><?php html_binary_branch($base8[71])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[37])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[72])?></li>
                                                                                            <li><?php html_binary_branch($base8[73])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[19])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[38])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[74])?></li>
                                                                                            <li><?php html_binary_branch($base8[75])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[39])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[76])?></li>
                                                                                            <li><?php html_binary_branch($base8[77])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[5])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[10])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[20])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li><?php html_binary_branch($base7[40])?></li>
                                                                                    <li><?php html_binary_branch($base7[41])?></li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[21])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[42])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[78])?></li>
                                                                                            <li><?php html_binary_branch($base8[79])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[43])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[80])?></li>
                                                                                            <li><?php html_binary_branch($base8[81])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[11])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[22])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[44])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[82])?></li>
                                                                                            <li><?php html_binary_branch($base8[83])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[45])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[84])?></li>
                                                                                            <li><?php html_binary_branch($base8[85])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[23])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[46])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[86])?></li>
                                                                                            <li><?php html_binary_branch($base8[87])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[47])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[88])?></li>
                                                                                            <li><?php html_binary_branch($base8[89])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base3[3])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[6])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[12])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[24])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[48])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[90])?></li>
                                                                                            <li><?php html_binary_branch($base8[91])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[49])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[92])?></li>
                                                                                            <li><?php html_binary_branch($base8[93])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[25])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[50])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[94])?></li>
                                                                                            <li><?php html_binary_branch($base8[95])?></li>
                                                                                        </ul
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[51])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[96])?></li>
                                                                                            <li><?php html_binary_branch($base8[97])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[13])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[26])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[52])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[98])?></li>
                                                                                            <li><?php html_binary_branch($base8[99])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[53])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[100])?></li>
                                                                                            <li><?php html_binary_branch($base8[101])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[27])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[54])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[102])?></li>
                                                                                            <li><?php html_binary_branch($base8[103])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[55])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[104])?></li>
                                                                                            <li><?php html_binary_branch($base8[105])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[7])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[14])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[28])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[56])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[106])?></li>
                                                                                            <li><?php html_binary_branch($base8[107])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[57])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[108])?></li>
                                                                                            <li><?php html_binary_branch($base8[109])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[29])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[58])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[110])?></li>
                                                                                            <li><?php html_binary_branch($base8[111])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[59])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[112])?></li>
                                                                                            <li><?php html_binary_branch($base8[113])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[15])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[30])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[60])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[114])?></li>
                                                                                            <li><?php html_binary_branch($base8[115])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[61])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[116])?></li>
                                                                                            <li><?php html_binary_branch($base8[117])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[31])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[62])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[118])?></li>
                                                                                            <li><?php html_binary_branch($base8[119])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[63])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[120])?></li>
                                                                                            <li><?php html_binary_branch($base8[121])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
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
                                                        <?php html_binary_branch($base3[4])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[8])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[16])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[32])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[64])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[122])?></li>
                                                                                            <li><?php html_binary_branch($base8[123])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[65])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[124])?></li>
                                                                                            <li><?php html_binary_branch($base8[125])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[33])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[66])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[126])?></li>
                                                                                            <li><?php html_binary_branch($base8[127])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[67])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[128])?></li>
                                                                                            <li><?php html_binary_branch($base8[129])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[17])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[34])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[68])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[130])?></li>
                                                                                            <li><?php html_binary_branch($base8[131])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[69])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[132])?></li>
                                                                                            <li><?php html_binary_branch($base8[133])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[35])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[70])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[134])?></li>
                                                                                            <li><?php html_binary_branch($base8[135])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[71])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[136])?></li>
                                                                                            <li><?php html_binary_branch($base8[137])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[9])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[18])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[36])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[72])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[138])?></li>
                                                                                            <li><?php html_binary_branch($base8[139])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[73])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[140])?></li>
                                                                                            <li><?php html_binary_branch($base8[141])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[37])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[74])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[142])?></li>
                                                                                            <li><?php html_binary_branch($base8[143])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[75])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[144])?></li>
                                                                                            <li><?php html_binary_branch($base8[145])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[19])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[38])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[76])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[146])?></li>
                                                                                            <li><?php html_binary_branch($base8[147])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[77])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[148])?></li>
                                                                                            <li><?php html_binary_branch($base8[149])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[39])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[78])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[150])?></li>
                                                                                            <li><?php html_binary_branch($base8[151])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[79])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[152])?></li>
                                                                                            <li><?php html_binary_branch($base8[153])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[10])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[20])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[40])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[80])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[154])?></li>
                                                                                            <li><?php html_binary_branch($base8[155])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[81])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[156])?></li>
                                                                                            <li><?php html_binary_branch($base8[157])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[41])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[82])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[158])?></li>
                                                                                            <li><?php html_binary_branch($base8[159])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[83])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[160])?></li>
                                                                                            <li><?php html_binary_branch($base8[161])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[21])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[42])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[84])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[162])?></li>
                                                                                            <li><?php html_binary_branch($base8[163])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[85])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[164])?></li>
                                                                                            <li><?php html_binary_branch($base8[165])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[43])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[86])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[166])?></li>
                                                                                            <li><?php html_binary_branch($base8[167])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[87])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[168])?></li>
                                                                                            <li><?php html_binary_branch($base8[169])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[11])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[22])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[44])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[88])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[170])?></li>
                                                                                            <li><?php html_binary_branch($base8[171])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[89])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[172])?></li>
                                                                                            <li><?php html_binary_branch($base8[173])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[45])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[90])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[174])?></li>
                                                                                            <li><?php html_binary_branch($base8[175])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[91])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[176])?></li>
                                                                                            <li><?php html_binary_branch($base8[177])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[23])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[46])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[92])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[178])?></li>
                                                                                            <li><?php html_binary_branch($base8[179])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[93])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[180])?></li>
                                                                                            <li><?php html_binary_branch($base8[181])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[47])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[94])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[182])?></li>
                                                                                            <li><?php html_binary_branch($base8[183])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[95])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[184])?></li>
                                                                                            <li><?php html_binary_branch($base8[185])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
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
                                                        <?php html_binary_branch($base3[5])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[12])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[24])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[48])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[96])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[186])?></li>
                                                                                            <li><?php html_binary_branch($base8[187])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[97])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[188])?></li>
                                                                                            <li><?php html_binary_branch($base8[189])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[49])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[98])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[190])?></li>
                                                                                            <li><?php html_binary_branch($base8[191])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[99])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[192])?></li>
                                                                                            <li><?php html_binary_branch($base8[193])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[25])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[50])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[100])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[194])?></li>
                                                                                            <li><?php html_binary_branch($base8[195])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[101])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[196])?></li>
                                                                                            <li><?php html_binary_branch($base8[197])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[51])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[102])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[198])?></li>
                                                                                            <li><?php html_binary_branch($base8[199])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[103])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[200])?></li>
                                                                                            <li><?php html_binary_branch($base8[201])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[13])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[26])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[52])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[104])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[202])?></li>
                                                                                            <li><?php html_binary_branch($base8[203])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[105])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[204])?></li>
                                                                                            <li><?php html_binary_branch($base8[205])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[53])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[106])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[206])?></li>
                                                                                            <li><?php html_binary_branch($base8[207])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[107])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[208])?></li>
                                                                                            <li><?php html_binary_branch($base8[209])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[27])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[54])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[108])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[210])?></li>
                                                                                            <li><?php html_binary_branch($base8[211])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[109])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[212])?></li>
                                                                                            <li><?php html_binary_branch($base8[213])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[55])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[110])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[214])?></li>
                                                                                            <li><?php html_binary_branch($base8[215])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[111])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[216])?></li>
                                                                                            <li><?php html_binary_branch($base8[217])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <?php html_binary_branch($base2[0])?>
                                                        <!-- BASE 4 -->
                                                        <ul>
                                                            <li>
                                                                <?php html_binary_branch($base4[14])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[28])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[56])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[112])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[218])?></li>
                                                                                            <li><?php html_binary_branch($base8[219])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[113])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[220])?></li>
                                                                                            <li><?php html_binary_branch($base8[221])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[57])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[114])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[222])?></li>
                                                                                            <li><?php html_binary_branch($base8[223])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[115])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[224])?></li>
                                                                                            <li><?php html_binary_branch($base8[225])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[29])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[58])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[116])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[226])?></li>
                                                                                            <li><?php html_binary_branch($base8[227])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[117])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[228])?></li>
                                                                                            <li><?php html_binary_branch($base8[229])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[59])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[118])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[230])?></li>
                                                                                            <li><?php html_binary_branch($base8[231])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[119])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[232])?></li>
                                                                                            <li><?php html_binary_branch($base8[233])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <?php html_binary_branch($base4[15])?>
                                                                <!-- BASE 5 -->
                                                                <ul>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[30])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[60])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[120])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[234])?></li>
                                                                                            <li><?php html_binary_branch($base8[235])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[121])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[236])?></li>
                                                                                            <li><?php html_binary_branch($base8[237])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[61])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[122])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[238])?></li>
                                                                                            <li><?php html_binary_branch($base8[239])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[123])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[240])?></li>
                                                                                            <li><?php html_binary_branch($base8[241])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>
                                                                        <?php html_binary_branch($base5[31])?>
                                                                        <!-- BASE 6 -->
                                                                        <ul>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[62])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[124])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[242])?></li>
                                                                                            <li><?php html_binary_branch($base8[243])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[125])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[244])?></li>
                                                                                            <li><?php html_binary_branch($base8[245])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>
                                                                                <?php html_binary_branch($base6[63])?>
                                                                                <!-- BASE 7 -->
                                                                                <ul>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[126])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[246])?></li>
                                                                                            <li><?php html_binary_branch($base8[247])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?php html_binary_branch($base7[127])?>
                                                                                        <!-- BASE 8 -->
                                                                                        <ul>
                                                                                            <li><?php html_binary_branch($base8[248])?></li>
                                                                                            <li><?php html_binary_branch($base8[249])?></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
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