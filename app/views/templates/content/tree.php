 <?php
    $img = URL.DS.'assets/img.png';
    $gen = $geneology;
?>>
<div class="tree">
    <ul>
        <li>
            <?php $id = $gen['root']->upline?>

            <?php if($id != 0) : ?>  
            <div class="arrow">
                <a href="/geneology/binary/<?php echo $id?>">
                    <i class="fa fa-arrow-up"></i>
                </a>
            </div>
            <?php endif;?>
            <div class="circle">
                <img src="<?php echo $img;?>"> 
            </div>
            <span>
                <strong><?php echo $gen['root']->username?></strong>
            </span> 
            
            <ul> 
                 <!--- node -->    
                <li>
                    <?php $id = $gen['level1']['left']->id?>    
                    <a href="/geneology/binary/<?php echo $id?>">
                        <div class="circle">
                            <img src="<?php echo $img;?>"> 
                        </div>
                        <span>
                            <strong>LEVEL 1 LEFT</strong>
                            <strong>/<?php echo $gen['level1']['left']->username?></strong>
                        </span>
                        <div class="position">left</div>
                    </a>
                    <!-- pair -->
                    <ul>
                        <li>
                            <?php $id = $gen['level2']['left']['left']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong>LEVEL 2 LEFT</strong>
                                    <strong>/<?php echo $gen['level2']['left']['left']->username?></strong>
                                </span>
                                <div class="position">LEFT</div>
                            </a>
                        </li>

                        <li>
                            <?php $id = $gen['level2']['left']['right']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong>LEVEL 2 RIGHT</strong>
                                    <strong>/<?php echo $gen['level2']['right']['right']->username?></strong>
                                </span>
                                <div class="position">RIGHT</div>
                            </a>
                        </li>
                    </ul>
                    <!--// pair -->
                </li>               
                <li>
                    <?php $id = $gen['level1']['right']->id?>
                    <a href="/geneology/binary/<?php echo $id?>">
                        <div class="circle">
                            <img src="<?php echo $img;?>"> 
                        </div>
                        <span>
                            <strong>LEVEL 1 RIGHT</strong>
                            <strong>/<?php echo $gen['level1']['right']->username?></strong>
                        </span>
                        <div class="position">left</div>
                    </a>
                    <!-- pair -->
                    <ul>
                        <li>
                            <?php $id = $gen['level2']['right']['left']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong>LEVEL 2 LEFT</strong>
                                   <strong>/<?php echo $gen['level2']['right']['left']->username?></strong>
                                </span>
                                <div class="position">LEFT</div>
                            </a> 
                        </li>

                        <li>
                            <?php $id = $gen['level2']['right']['right']->id?>
                            <a href="/geneology/binary/<?php echo $id?>">
                                <div class="circle">
                                    <img src="<?php echo $img;?>"> 
                                </div>
                                <span>
                                    <strong>LEVEL 2 RIGHT</strong>
                                    <strong>/<?php echo $gen['level2']['right']['right']->username?></strong>
                                </span>
                                <div class="position">RIGHT</div>
                            </a>
                        </li>
                    </ul>
                    <!--// pair -->
                </li>                     
            </ul>            
        </li>
    </ul>
</div>