<?php build('content')?>
    <h4 class="text-danger"><?php echo $title?></h4>

    <?php 
    Form::open([
        'method' => 'get',
        'action' => '/Support/update/'
    ])?>
        <table class="table">
            <thead>
                <th>Username</th>
                <th>New Sponsor</th>
                <th>New Upline</th>
                <th>Position</th>
            </thead>

            <tbody>
                <td>
                    <?php Form::text('user' , '' , [
                        'placeholder' => 'Search By Username or name',
                        'class' => 'form-control user_search',
                        'data-fill' => '.user-container'
                    ])?>

                    <div class="user_container">
                        
                    </div>
                </td>

                <td>
                    <?php Form::text('sponsor' , '' , [
                        'placeholder' => 'Search By Username',
                        'class' => 'form-control sponsor_search',
                        'data-fill' => '.sponsor-container'
                    ])?>
                    <div class="sponsor_container">
                        
                    </div>
                </td>

                <td>
                    <?php Form::text('upline' , '' , [
                        'placeholder' => 'Search By Username',
                        'class' => 'form-control upline_search',
                        'data-fill' => '.upline-container'
                    ])?>
                    <div class="upline_container">
                        
                    </div>
                </td>

                <td>
                    <?php Form::select(
                    'position' , 
                    [
                        'left' => 'LEFT',
                        'right' => 'RIGHT'
                    ] ,

                    '',
                    [
                        'class' => 'form-control'
                    ]
                    )?>
                </td>
            </tbody>
        </table>

        <?php Form::submit('' , 'Save' , ['class' => 'btn btn-primary btn-sm'])?>
    <?php  Form::close()?>
<?php endbuild()?>

<?php build('scripts')?>
    <script src="<?php echo URL.DS?>js/sponsor_and_upline.js"></script>
<?php endbuild()?>
<?php build('headers')?>
    <style>
        .chkbox{
            font-size: 1.5em;
            padding: 2px;
            margin-bottom: 5px;
            border-bottom: 1px solid #000;
        }
    </style>
<?php endbuild()?>




<?php occupy('templates.layout')?>