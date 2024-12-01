 <?php
    $img = URL.DS.'assets/img.png';
    $gen = $geneology;
?>>
<div class="tree">
    <ul>
        <li>
            <?php $id = $root->upline?>

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
                    <?php $id = $gen['2.1']->id?> 
                    <a href="/geneology/binary/<?php echo $id?>">
                        <div class="circle user-<?php echo $gen['2.1']->status;?>">
                            <img src="<?php echo $img;?>"> 
                        </div>
                        <span>
                            <strong><?php echo $gen['2.1']->status?></strong>
                            <div><?php echo $gen['2.1']->username?></div>
                            <div>left : <?php echo $gen['2.1']->left?></div>
                            <div>right : <?php echo $gen['2.1']->right?></div>
                        </span>
                        <div class="position">left</div>
                    </a>
                    <!-- level 3-->
                    <ul>
                        <li>
                            <?php $id = $gen['3.1']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle user-<?php echo $gen['3.1']->status;?>">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong><?php echo $gen['3.1']->status?></strong>
                                    <div><?php echo $gen['3.1']->username?></div>
                                    <div>left : <?php echo $gen['3.1']->left?></div>
                                    <div>right : <?php echo $gen['3.1']->right?></div>
                                </span>
                                <div class="position">LEFT</div>
                            </a>

                            <ul>
                                <li>
                                    <?php $id = $gen['4.1']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.1']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.1']->status?></strong>
                                            <div><?php echo $gen['4.1']->username?></div>
                                            <div>left : <?php echo $gen['4.1']->left?></div>
                                            <div>right : <?php echo $gen['4.1']->right?></div>
                                        </span>
                                        <div class="position">LEFT</div>
                                    </a>


                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.1']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.1']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.1']->status?></strong>
                                                    <div><?php echo $gen['5.1']->username?></div>
                                                    <div>left : <?php echo $gen['5.1']->left?></div>
                                                    <div>right : <?php echo $gen['5.1']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.2']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.2']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.1']->status?></strong>
                                                    <div><?php echo $gen['5.2']->username?></div>
                                                    <div>left : <?php echo $gen['5.1']->left?></div>
                                                    <div>right : <?php echo $gen['5.1']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <?php $id = $gen['4.2']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.2']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.2']->status?></strong>
                                            <div><?php echo $gen['4.2']->username?></div>
                                            <div>left : <?php echo $gen['4.2']->left?></div>
                                            <div>right : <?php echo $gen['4.2']->right?></div>
                                        </span>
                                        <div class="position">RIGHT</div>
                                    </a>

                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.3']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.3']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.3']->status?></strong>
                                                    <div><?php echo $gen['5.3']->username?></div>
                                                    <div>left : <?php echo $gen['5.3']->left?></div>
                                                    <div>right : <?php echo $gen['5.3']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.4']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.4']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.4']->status?></strong>
                                                    <div><?php echo $gen['5.4']->username?></div>
                                                    <div>left : <?php echo $gen['5.4']->left?></div>
                                                    <div>right : <?php echo $gen['5.4']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <?php $id = $gen['3.2']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle user-<?php echo $gen['3.2']->status;?>">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong><?php echo $gen['3.2']->status?></strong>
                                    <div><?php echo $gen['3.2']->username?></div>
                                    <div>left : <?php echo $gen['3.2']->left?></div>
                                    <div>right : <?php echo $gen['3.2']->right?></div>
                                </span>
                                <div class="position">RIGHT</div>
                            </a>
                            <ul>
                                <li>
                                    <?php $id = $gen['4.3']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.3']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.3']->status?></strong>
                                            <div>left : <?php echo $gen['4.3']->left?></div>
                                            <div>right : <?php echo $gen['4.3']->right?></div>
                                        </span>
                                        <div class="position">LEFT</div>
                                    </a>

                                        <ul>
                                            <li>
                                                <?php $id = $gen['5.5']->id?>
                                                <a href="/geneology/binary/<?php echo $id?>">
                                                    <div class="circle user-<?php echo $gen['5.5']->status;?>">
                                                        <img src="<?php echo $img;?>"> 
                                                    </div>
                                                    <span>
                                                        <strong><?php echo $gen['5.5']->status?></strong>
                                                        <div><?php echo $gen['5.5']->username?></div>
                                                        <div>left : <?php echo $gen['5.5']->left?></div>
                                                        <div>right : <?php echo $gen['5.5']->right?></div>
                                                    </span>
                                                    <div class="position">LEFT</div>
                                                </a>
                                            </li>

                                            <li>
                                                <?php $id = $gen['5.5']->id?>
                                                <a href="/geneology/binary/<?php echo $id?>">
                                                    <div class="circle user-<?php echo $gen['5.5']->status;?>">
                                                        <img src="<?php echo $img;?>"> 
                                                    </div>
                                                    <span>
                                                        <strong><?php echo $gen['5.6']->status?></strong>
                                                        <div><?php echo $gen['5.6']->username?></div>
                                                        <div>left : <?php echo $gen['5.6']->left?></div>
                                                        <div>right : <?php echo $gen['5.6']->right?></div>
                                                    </span>
                                                    <div class="position">RIGHT</div>
                                                </a>
                                            </li>
                                        </ul>
                                </li>

                                <li>
                                    <?php $id = $gen['4.4']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.4']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.4']->status?></strong>
                                            <div><?php echo $gen['4.4']->username?></div>
                                            <div>left : <?php echo $gen['4.4']->left?></div>
                                            <div>right : <?php echo $gen['4.4']->right?></div>
                                        </span>
                                        <div class="position">RIGHT</div>
                                    </a>

                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.7']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.7']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.7']->status?></strong>
                                                    <div><?php echo $gen['5.7']->username?></div>
                                                    <div>left : <?php echo $gen['5.7']->left?></div>
                                                    <div>right : <?php echo $gen['5.7']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.8']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.8']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.8']->status?></strong>
                                                    <div><?php echo $gen['5.8']->username?></div>
                                                    <div>left : <?php echo $gen['5.8']->left?></div>
                                                    <div>right : <?php echo $gen['5.8']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!--// pair -->
                </li>               
                <li>
                    <?php $id = $gen['2.2']->id?>
                    <a href="/geneology/binary/<?php echo $id?>">
                        <div class="circle user-<?php echo $gen['2.2']->status;?>">
                            <img src="<?php echo $img;?>"> 
                        </div>
                        <span>
                            <strong>2.2</strong>
                            <div><?php echo $gen['2.2']->username?></div>
                            <div>left : <?php echo $gen['2.2']->left?></div>
                            <div>right : <?php echo $gen['2.2']->right?></div>
                        </span>
                        <div class="position">left</div>
                    </a>
                    <!-- level 3-->
                    <ul>
                        <li>
                            <?php $id = $gen['3.3']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle user-<?php echo $gen['3.3']->status;?>">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong><?php echo $gen['3.3']->status?></strong>
                                    <div><?php echo $gen['3.3']->username?></div>
                                    <div>left : <?php echo $gen['3.3']->left?></div>
                                    <div>right : <?php echo $gen['3.3']->right?></div>
                                </span>
                                <div class="position">LEFT</div>
                            </a>
                            <ul>
                                <li>
                                    <?php $id = $gen['4.5']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.5']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.5']->status?></strong>
                                            <div><?php echo $gen['4.5']->username?></div>
                                            <div>left : <?php echo $gen['4.5']->left?></div>
                                            <div>right : <?php echo $gen['4.5']->right?></div>
                                        </span>
                                        <div class="position">LEFT</div>
                                    </a>

                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.9']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.9']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.9']->status?></strong>
                                                    <div><?php echo $gen['5.9']->username?></div>
                                                    <div>left : <?php echo $gen['5.9']->left?></div>
                                                    <div>right : <?php echo $gen['5.9']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.10']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.10']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.10']->status?></strong>
                                                    <div><?php echo $gen['5.10']->username?></div>
                                                    <div>left : <?php echo $gen['5.10']->left?></div>
                                                    <div>right : <?php echo $gen['5.10']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
                                        </li>
                                    </ul> 
                                </li>

                                <li>
                                    <?php $id = $gen['4.6']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.6']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                           <strong><?php echo $gen['4.6']->status?></strong>
                                            <div><?php echo $gen['4.6']->username?></div>
                                            <div>left : <?php echo $gen['4.6']->left?></div>
                                            <div>right : <?php echo $gen['4.6']->right?></div>
                                        </span>
                                        <div class="position">RIGHT</div>
                                    </a>

                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.11']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.11']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.11']->status?></strong>
                                                    <div><?php echo $gen['5.11']->username?></div>
                                                    <div>left : <?php echo $gen['5.11']->left?></div>
                                                    <div>right : <?php echo $gen['5.11']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.12']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.12']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.12']->status?></strong>
                                                    <div><?php echo $gen['5.12']->username?></div>
                                                    <div>left : <?php echo $gen['5.12']->left?></div>
                                                    <div>right : <?php echo $gen['5.12']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul> 
                        </li>

                        <li>
                            <?php $id = $gen['3.4']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle user-<?php echo $gen['3.4']->status;?>">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong><?php echo $gen['3.4']->status?></strong>
                                    <div><?php echo $gen['3.4']->username?></div>
                                    <div>left : <?php echo $gen['3.4']->left?></div>
                                    <div>right : <?php echo $gen['3.4']->right?></div>
                                </span>
                                <div class="position">RIGHT</div>
                            </a>
                            <ul>
                                <li>
                                    <?php $id = $gen['4.7']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.7']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.7']->status?></strong>
                                            <div><?php echo $gen['4.7']->username?></div>
                                            <div>left : <?php echo $gen['4.7']->left?></div>
                                            <div>right : <?php echo $gen['4.7']->right?></div>
                                        </span>
                                        <div class="position">LEFT</div>
                                    </a>

                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.13']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.13']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.13']->status?></strong>
                                                    <div><?php echo $gen['5.13']->username?></div>
                                                    <div>left : <?php echo $gen['5.13']->left?></div>
                                                    <div>right : <?php echo $gen['5.13']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.14']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.14']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.14']->status?></strong>
                                                    <div><?php echo $gen['5.14']->username?></div>
                                                    <div>left : <?php echo $gen['5.14']->left?></div>
                                                    <div>right : <?php echo $gen['5.14']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
                                        </li>
                                    </ul> 
                                </li>

                                <li>
                                    <?php $id = $gen['4.8']->id?>
                                    <a href="/geneology/binary/<?php echo $id?>">
                                        <div class="circle user-<?php echo $gen['4.8']->status;?>">
                                            <img src="<?php echo $img;?>"> 
                                        </div>
                                        <span>
                                            <strong><?php echo $gen['4.8']->status?></strong>
                                            <div><?php echo $gen['4.8']->username?></div>
                                            <div>left : <?php echo $gen['4.8']->left?></div>
                                            <div>right : <?php echo $gen['4.8']->right?></div>
                                        </span>
                                        <div class="position">RIGHT</div>
                                    </a>

                                    <ul>
                                        <li>
                                            <?php $id = $gen['5.15']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.15']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.15']->status?></strong>
                                                    <div><?php echo $gen['5.15']->username?></div>
                                                    <div>left : <?php echo $gen['5.15']->left?></div>
                                                    <div>right : <?php echo $gen['5.15']->right?></div>
                                                </span>
                                                <div class="position">LEFT</div>
                                            </a>
                                        </li>

                                        <li>
                                            <?php $id = $gen['5.16']->id?>
                                            <a href="/geneology/binary/<?php echo $id?>">
                                                <div class="circle user-<?php echo $gen['5.16']->status;?>">
                                                    <img src="<?php echo $img;?>"> 
                                                </div>
                                                <span>
                                                    <strong><?php echo $gen['5.16']->status?></strong>
                                                    <div><?php echo $gen['5.16']->username?></div>
                                                    <div>left : <?php echo $gen['5.16']->left?></div>
                                                    <div>right : <?php echo $gen['5.16']->right?></div>
                                                </span>
                                                <div class="position">RIGHT</div>
                                            </a>
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