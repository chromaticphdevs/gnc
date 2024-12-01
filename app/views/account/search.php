<?php build('content') ?>
<div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Search User')) ?>
        <div class="card-body">
            <form method="get" action="/Account/doSearch">
                <div class="form-group">
                    <label>Username Only</label>
                    <input type="text" name="username" class="form-control">
                </div>

                <?php echo wDivider(20)?>

                <div class="form-group">
                    <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) :?>
                        <label for="usernameRadio">
                            <input type="radio" name="searchOption" id="usernameRadio" value="username" checked>
                            Username
                        </label>
                    <?php endif?>

                    <label for="emailRadio">
                        <input type="radio" name="searchOption" id="emailRadio" value="email" checked>
                        Email
                    </label>
                    
                    <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) :?>
                    <label for="firstname">
                        <input type="radio" name="searchOption" id="firstname" value="firstname" checked>
                        Firstname
                    </label>

                    <label for="lastname">
                        <input type="radio" name="searchOption" id="lastname" value="lastname" checked>
                        Lastname
                    </label>
                    <?php endif?>
                </div>

                <div class="form-group">
                    <input type="submit" name="" class="btn btn-primary" value="search">
                </div>
            </form>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php occupy('templates/layout')?>
