<?php build('content') ?>
<section id="main_content">
    <h3>Binary</h3>
    <?php Flash::show()?>
    <section id="center">
    <?php if(!isEqual($userInfo['status'] , ['starter' , 'bronze' , 'pre-activated']) || whoIs('type') == '1') : ?>
    <div class="tree">
        <?php $img = URL.DS.'uploads/binary_icon_2.png';?>
        <?php $class = strtolower($root->status) == null ? 'no-user' : strtolower($root->status);?>
        <ul>
            <li>
                <?php if($userid != $root->id) :?>
                    <div>
                        <a href="?userid=<?php echo $root->upline?>" class="<?php echo $class?>"><h3>GO UP</h3></a>
                    </div>
                <?php endif?>
                <a href="#" title="<?php echo $root->username?>" class="<?php echo $class?>">
                    <div class="circle user-<?php echo $userData['status'];?>">
                        <img src="<?php echo $img;?>">
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
                        ];
                    ?>
                    <?php $b1 = 0?>
                    <?php $b2 = 0?>
                    <?php $b3 = 0?>
                    <?php $b4 = 0?>
                    <?php $b5 = 0?>
                    <?php $b6 = 0?>
                    <?php $b7 = 0?>

                    <!-- BASE 1 -->
                    <?php while($b1 < ($sw['base1'] + 2) && $sw['base1'] < count($base1)) :?>
                        <li>
                            <?php html_binary_branch($base1[$b1])?>
                            <ul>
                                <!-- BASE 2 -->
                                <?php while($b2 < ($sw['base2'] + 2) && $sw['base2'] < count($base2)) : ?>
                                    <li>
                                        <?php html_binary_branch($base2[$b2])?>
                                        <ul>
                                            <!-- BASE 3 -->
                                            <?php while($b3 < ($sw['base3'] + 2) && $sw['base3'] < count($base3)) : ?>
                                                <li>
                                                    <?php html_binary_branch($base3[$b3])?>
                                                    <ul>
                                                        <!-- BASE 4 -->
                                                        <?php while($b4 < ($sw['base4'] + 2) && $sw['base4'] < count($base4)) : ?>
                                                            <li>
                                                                <?php html_binary_branch($base4[$b4])?>
                                                                <ul>
                                                                    <!-- BASE 5 -->
                                                                    <?php while($b5 < ($sw['base5'] + 2) && $sw['base5'] < count($base5)) : ?>
                                                                        <li>
                                                                            <?php html_binary_branch($base5[$b5])?>
                                                                            <ul>
                                                                              <!-- BASE 6 -->
                                                                              <?php while($b6 < ($sw['base6'] + 2) && $sw['base6'] < count($base6)) : ?>
                                                                                  <li>
                                                                                      <?php html_binary_branch($base6[$b6])?>
                                                                                  </li>
                                                                                  <?php $b6++?>
                                                                              <?php endwhile?>

                                                                              <?php $sw['base6'] = $b6?>
                                                                            </ul>
                                                                        </li>
                                                                        <?php $b5++?>
                                                                    <?php endwhile?>

                                                                    <?php $sw['base5'] = $b5?>
                                                                </ul>
                                                            </li>
                                                            <?php $b4++?>
                                                        <?php endwhile?>
                                                        <?php $sw['base4'] = $b4?>
                                                    </ul>
                                                </li>
                                                <?php $b3++?>
                                            <?php endwhile?>
                                            <?php $sw['base3'] = $b3?>
                                        </ul>
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
    <?php else:?>
    <h4>Currenly not available if your membership level is in the ff. 'starter' , 'bronze'</h4>
    <?php endif;?>
</section>
<?php endbuild()?>


<?php build('headers') ?>
<style>
    div.right_col{

        overflow: none !important;
    }

    .x_panel{
        height: 100vh;
        overflow: scroll;
    }

    div.tree div.user-starter{
        background: green;
    }
    div.tree div.user-bronze{
        background: #5B391e;
    }
    div.tree div.user-silver{
        background: #6e7a91;
    }

    div.tree div.user-gold{
        background: #9A801E;
    }

    div.tree div.user-platinum{
        background: #423CA2;
    }

    div.tree div.user-diamond{
        background: #19759D;
    }


    div.tree div.user-pre-activated
    {
        background: blue;
    }

    div.circle{
        width: 30px !important;
        height: 30px !important;
        border-radius: 5px !important;
    }

    div.circle > * 
    {
        width: 100%;
        height: 100%;
    }

    .binary-user > *
    {
        font-size: .75em !important;
    }
</style>
<?php endbuild()?>
<?php occupy('templates/old_layout')?>
