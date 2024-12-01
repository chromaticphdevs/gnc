<div class="profile clearfix">
    <div class="profile_pic">
        <?php showProfile()?>
    </div>
    <div class="profile_info">
        <h2><?php get_user_username()?></h2>
        <div style="color:#fff">
        	<strong>
        		<?php get_user_status()?>
        	</strong>
            <?php echo userVerfiedText(whoIs())?>
        </div>
        <p>&nbsp;</p>
    </div>
</div>