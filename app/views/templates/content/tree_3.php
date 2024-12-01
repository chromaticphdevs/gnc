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
                                            <ul>
                                                <li>
                                                    <?php html_binary_widget($gen['6.1'] , '6.1' , 'LEFT' , $gen['5.1']) ?>
                                                </li>
                                                <li>
                                                    <?php html_binary_widget($gen['6.2'] , '6.2' , 'RIGHT' , $gen['5.1']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.2'] , '5.2' , 'RIGHT' , $gen['4.1']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.3'] , '6.3' , 'LEFT' , $gen['5.2']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.4'] , '6.4' , 'RIGHT' , $gen['5.2']) ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.2'] , '4.2' , 'RIGHT' , $gen['3.1']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.3'] , '5.3' , 'LEFT' , $gen['4.2']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.5'] , '6.5' , 'LEFT' , $gen['5.3']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.6'] , '6.6' , 'RIGHT' , $gen['5.3']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.4'] , '5.4' , 'RIGHT' , $gen['4.2']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.7'] , '6.7' , 'LEFT' , $gen['5.4']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.8'] , '6.8' , 'RIGHT' , $gen['5.4']) ?>
                                                </li>
                                            </ul>
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
                                                <ul>
                                                    <li>
                                                    <?php html_binary_widget($gen['6.9'] , '6.9' , 'LEFT' , $gen['5.5']) ?>
                                                    </li>
                                                    <li>
                                                    <?php html_binary_widget($gen['6.10'] , '6.10' , 'RIGHT' , $gen['5.5']) ?>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li>
                                                <?php html_binary_widget($gen['5.6'] , '5.6' , 'RIGHT' , $gen['4.3']) ?>
                                                <ul>
                                                    <li>
                                                    <?php html_binary_widget($gen['6.11'] , '6.11' , 'LEFT' , $gen['5.6']) ?>
                                                    </li>
                                                    <li>
                                                    <?php html_binary_widget($gen['6.12'] , '6.12' , 'RIGHT' , $gen['5.6']) ?>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.4'] , '4.4' , 'RIGHT' , $gen['3.2']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.7'] , '5.7' , 'LEFT', $gen['4.4']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.13'] , '6.13' , 'LEFT' , $gen['5.7']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.14'] , '6.14' , 'RIGHT' , $gen['5.7']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.8'] , '5.8' , 'RIGHT', $gen['4.4']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.15'] , '6.15' , 'LEFT' , $gen['5.8']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.16'] , '6.16' , 'RIGHT' , $gen['5.8']) ?>
                                                </li>
                                            </ul>
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
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.17'] , '6.17' , 'LEFT' , $gen['5.9']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.18'] , '6.18' , 'RIGHT' , $gen['5.9']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.10'] , '5.10' , 'RIGHT', $gen['4.5']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.19'] , '6.19' , 'LEFT' , $gen['5.10']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.20'] , '6.20' , 'RIGHT' , $gen['5.10']) ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul> 
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.6'] , '4.6' , 'RIGHT', $gen['3.3']) ?>
                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.11'] , '5.11' , 'LEFT', $gen['4.6']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.21'] , '6.21' , 'LEFT' , $gen['5.11']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.22'] , '6.22' , 'RIGHT' , $gen['5.11']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.12'] , '5.12' , 'RIGHT', $gen['4.6']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.23'] , '6.23' , 'LEFT' , $gen['5.12']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.24'] , '6.24' , 'RIGHT' , $gen['5.12']) ?>
                                                </li>
                                            </ul>
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
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.25'] , '6.25' , 'LEFT' , $gen['5.13']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.26'] , '6.26' , 'RIGHT' , $gen['5.13']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.14'] , '5.14' , 'RIGHT', $gen['4.7']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.27'] , '6.27' , 'LEFT' , $gen['5.14']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.28'] , '6.28' , 'RIGHT' , $gen['5.14']) ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul> 
                                </li>

                                <li>
                                    <?php html_binary_widget($gen['4.8'] , '4.8' , 'RIGHT', $gen['3.4']) ?>

                                    <ul>
                                        <li>
                                            <?php html_binary_widget($gen['5.15'] , '5.15' , 'LEFT', $gen['4.8']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.29'] , '6.29' , 'LEFT' , $gen['5.15']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.30'] , '6.30' , 'RIGHT' , $gen['5.15']) ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <?php html_binary_widget($gen['5.16'] , '5.16' , 'RIGHT', $gen['4.8']) ?>
                                            <ul>
                                                <li>
                                                <?php html_binary_widget($gen['6.31'] , '6.31' , 'LEFT' , $gen['5.16']) ?>
                                                </li>
                                                <li>
                                                <?php html_binary_widget($gen['6.32'] , '6.32' , 'RIGHT' , $gen['5.16']) ?>
                                                </li>
                                            </ul>
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