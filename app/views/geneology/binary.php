
<?php build('content') ?>
<h3>Teams</h3>
<?php Flash::show()?>
<div style="overflow-x:auto;">
    <section id="center" class="col-md-12">
        <div>
            View as
            <?php if(!isEqual($userInfo->status , ['starter' , 'bronze' , 'pre-activated'])) :?>
                <a href="?view=chart"> <span class="badge badge-primary">Chart</span> </a> | 
            <?php endif;?>
            <a href="?view=list"><span class="badge badge-primary">List</span></a>

            <a href="/geneology/binary">Reset</a>

             <form action="/geneology/seacrh_user" method="post" >
                  <input type="text" name="username" value="">
                  <input type="submit"  value="Search" class="btn btn-success btn-sm" >
             </form>
        </div>
        <hr>
        <div class="text-center" style="background: #16213e; color: #fff; padding: 10px;">
            <h4>
                <?php echo $root->firstname  . ' ' . $root->lastname?> <br/>
                (<?php echo $root->username?>)
            </h4>
        </div>
        <hr>
        <?php 

            $leftCustomers = [];
            $rightCustomers = [];

            foreach($geneology as $key => $row )
            {
                if( isEqual( $row->position , 'left')){
                    $leftCustomers [] = $row;
                }else{
                    $rightCustomers [] = $row;
                }
            }

            switch( strtolower($contentView) )
            {
                case 'chart':
                    if(isset($level) && $level == TRUE)
                    {
                        include_once(VIEWS.DS.'templates/content/tree_3.php');
                    }else{
                        include_once(VIEWS.DS.'templates/content/tree_2.php');
                    }
                break;

                case 'list':
                ?> 
                <?php $account_status = SESSION::get("USERSESSION")['status'];?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th>Membership</th>
                                        <!--<th>Customer</th>-->
                                    </thead>
                                            <?php $count_left = 0;?>    
                                    <tbody>
                                        <?php foreach($leftCustomers as $key => $row) :?>
                                            <?php if( isEqual($row->username , 'N/A') ) continue;?>

                                                <?php if($row->username != 'N/A'):?>
                                                    <?php $count_left++;?>    
                                                <?php endif;?>    
                                            <tr>
                                                <td>
                                                    <a href="/geneology/binary/<?php echo $row->id?>"><?php echo $row->first_name?></a>
                                                </td>
                                                <td><?php echo $row->last_name?></td>
                                                <td><?php echo $row->username?></td>
                                                <td><?php echo $row->status?></td>
                                                <!--<td>
                                                    
                                                    <a href="http://signup-e.com/RegistrationSignup/index?uplineid=<?php echo $row->id; ?>&position=left&direct=<?php echo SESSION::get("USERSESSION")['id']; ?>" target="_blank" class="btn btn-primary btn-sm">
                                                                    Add Customer
                                                                </a>
                                                </td>-->
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>

                                <?php if(empty($count_left) && isEqual($account_status, 'starter')):?>
                                        <?php
                                            $endpoint = 'https://signup-e.com/RegistrationSignup';
                                            $userId = SESSION::get("USERSESSION")['id'];
                                            $linkLEFT = $endpoint.'?q='.seal("position=LEFT&direct={$userId}&uplineid={$root->id}");
                                        ?>
                                    <a href="<?php echo $linkLEFT?>" target="_blank" class="btn btn-primary btn-sm">
                                                Add Customer
                                    </a>  
                                <?php endif;?>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th>Membership</th>
                                        <!--<th>Customer</th>-->
                                    </thead>
                                            <?php $count_right=0;?>    
                                    <tbody>
                                        <?php foreach($rightCustomers as $key => $row) :?>
                                            <?php if( isEqual($row->username , 'N/A') ) continue;?>

                                                <?php if($row->username != 'N/A'):?>
                                                    <?php $count_right++;?>    
                                                <?php endif;?>  

                                            <tr>
                                                <td>
                                                    <a href="/geneology/binary/<?php echo $row->id?>"><?php echo $row->first_name?></a>
                                                </td>
                                                <td><?php echo $row->last_name?></td>
                                                <td><?php echo $row->username?></td>
                                                <td><?php echo $row->status?></td>
                                                <!--<td>
                                                <a href="http://signup-e.com/RegistrationSignup/index?uplineid=<?php echo $row->id; ?>&position=right&direct=<?php echo SESSION::get("USERSESSION")['id']; ?>" target="_blank" class="btn btn-primary btn-sm">
                                                                    Add Customer
                                                                </a>
                                                </td>-->
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                                    <?php if(empty($count_right)&& isEqual($account_status, 'starter')):?>
                                        <?php
                                            $endpoint = 'https://signup-e.com/RegistrationSignup';
                                            $userId = SESSION::get("USERSESSION")['id'];
                                            $linkRight = $endpoint.'?q='.seal("position=RIGHT&direct={$userId}&uplineid={$root->id}");
                                        ?>
                                        <a href="<?php echo $linkRight?>" target="_blank" class="btn btn-primary btn-sm">
                                                Add Customer
                                        </a>  
                                    <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                break;
            }
        ?>
    </section>
</div>

<?php endbuild()?>


<?php build('scripts')?>
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
<?php endbuild()?>

<?php build('headers')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/geneology.css">
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
<?php occupy('templates/layout')?>