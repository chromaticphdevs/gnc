<?php
    $img = URL.DS.'uploads/binary_icon_2.png';
    $gen = $geneology;
?>
<div class="tree">
    <ul>
        <li>
            <?php $id = $root->upline ?>

            <?php if($userid != $root->id) : ?>
                <div>
                    <a href="/geneology/binary/<?php echo $userid?>">BACK TO TOP</a>
                </div>
            <?php endif;?>

            <?php if($id != 0 && ($userid != $root->id)) : ?>
                <div class="arrow">
                    <a href="/geneology/binary/<?php echo $id?>">
                        <i class="fa fa-arrow-up"></i>
                    </a>
                </div>
            <?php endif;?>
            <div class="circle user-<?php echo $root->status;?>">
                <img src="<?php echo $img;?>">
            </div>
            <span>
                <strong><?php echo $root->username?></strong>
                <label style="display: block;"><?php echo $root->status?></label>
            </span>

            <ul>
                 <!--- node -->
                <li>
                    <?php html_binary_widget($gen['2.1'] , '2.1' , 'LEFT' , $root) ?>
                    <!-- level 3 -->
                    <ul>
                        <li>
                            <?php html_binary_widget($gen['3.1'] , '3.1' , 'LEFT',$gen['2.1']) ?>
                            <ul>
                                <li>
                                    <?php html_binary_widget($gen['4.1'] , '4.1' , 'LEFT' , $gen['3.1']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.1'] , '5.1' , 'LEFT' , $gen['4.1']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.2'] , '5.2' , 'RIGHT' , $gen['4.1']) ?>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.2'] , '4.2' , 'RIGHT' , $gen['3.1']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.3'] , '5.3' , 'LEFT' , $gen['4.2']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.4'] , '5.4' , 'RIGHT' , $gen['4.2']) ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <?php html_binary_widget($gen['3.2'] , '3.2' , 'RIGHT' , $gen['2.1']) ?>
                            <ul>
                                <li>
                                    <?php html_binary_widget($gen['4.3'] , '4.3' , 'LEFT' , $gen['3.2']) ?>
                                        <ul>
                                            <li>
                                                <?php html_binary_widget($gen['5.5'] , '5.5' , 'LEFT' , $gen['4.3']) ?>
                                            </li>

                                            <li>
                                                <?php html_binary_widget($gen['5.6'] , '5.6' , 'RIGHT' , $gen['4.3']) ?>
                                            </li>
                                        </ul>
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.4'] , '4.4' , 'RIGHT' , $gen['3.2']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.7'] , '5.7' , 'LEFT', $gen['4.4']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.8'] , '5.8' , 'RIGHT', $gen['4.4']) ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!--// pair -->
                </li>
                <li>
                    <?php html_binary_widget($gen['2.2'] , '2.2' , 'RIGHT', $root) ?>
                    <!-- level 3-->
                    <ul>
                        <li>
                            <?php html_binary_widget($gen['3.3'] , '3.3' , 'LEFT', $gen['2.2']) ?>
                            <ul>
                                <li>
                                    <?php html_binary_widget($gen['4.5'] , '4.5' , 'LEFT', $gen['3.3']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.9'] , '5.9' , 'LEFT', $gen['4.5']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.10'] , '5.10' , 'RIGHT', $gen['4.5']) ?>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.6'] , '4.6' , 'RIGHT', $gen['3.3']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.11'] , '5.11' , 'LEFT', $gen['4.6']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.12'] , '5.12' , 'RIGHT', $gen['4.6']) ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <?php html_binary_widget($gen['3.4'] , '3.4' , 'RIGHT', $gen['2.2']) ?>
                            <ul>
                                <li>
                                    <?php html_binary_widget($gen['4.7'] , '4.7' , 'LEFT', $gen['3.4']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.13'] , '5.13' , 'LEFT', $gen['4.7']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.14'] , '5.14' , 'RIGHT', $gen['4.7']) ?>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.8'] , '4.8' , 'RIGHT', $gen['3.4']) ?>

                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.15'] , '5.15' , 'LEFT', $gen['4.8']) ?>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.16'] , '5.16' , 'RIGHT', $gen['4.8']) ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!--// pair -->
                </li>
            </ul>
        </li>
    </ul>
</div>
