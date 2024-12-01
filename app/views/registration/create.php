<?php build('content')?>
<div class="container-login100">
    <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
        <?php 
            Form::open([
                'method' => 'post' ,
                'action' => '/Registration/store'
            ]);
            Form::hidden('sponsor' , $sponsor);
        ?>
            <h3><?php Flash::show();?></h3>
            <span class="login100-form-title p-b-55">
                Pre-Registration
            </span>

            <!-- FIRST NAME -->
            <div class="form-group">
                <?php Form::label('First Name *' , 'firstname')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('firstname' , '' ,[
                        'id' => 'firstname',
                        'placeholder' => 'First Name',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- MIDDLENAME -->
            <div class="form-group">
                <?php Form::label('Middle Name *' , 'middlename')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('middlename' , '' ,[
                        'id' => 'middlename',
                        'placeholder' => 'Middle Name',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- LAST NAME -->
            <div class="form-group">
                <?php Form::label('Last Name *' , 'lastname')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('lastname' , '' ,[
                        'id' => 'lastname',
                        'placeholder' => 'Last Name',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- RELIGION -->
            <div class="form-group">
                <?php Form::label('Religion' , 'religion')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('religion' , '' ,[
                        'id' => 'religion',
                        'placeholder' => 'Religion',
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- CELLPHONE -->
            <div class="form-group">
                <?php Form::label('Mobile Number *' , 'mobile')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('mobile' , '' ,[
                        'id' => 'mobile',
                        'placeholder' => '11 digit number eg.09XXXXXXXXX',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

             <!-- EMAIL -->
             <div class="form-group">
                <?php Form::label('Email *' , 'email')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('email' , '' ,[
                        'id' => 'email',
                        'placeholder' => 'Email',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- USERNAME -->
            <div class="form-group">
                <?php Form::label('Username *' , 'username')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('username' , '' ,[
                        'id' => 'username',
                        'placeholder' => 'Username',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- HOUSE NUMBER -->
            <div class="form-group">
                <?php Form::label('House Number *' , 'housenumber')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('housenumber' , '' ,[
                        'id' => 'housenumber',
                        'placeholder' => 'House Number',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- HOUSE NUMBER -->
            <div class="form-group">
                <?php Form::label('Barangay *' , 'barangay')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('barangay' , '' ,[
                        'id' => 'barangay',
                        'placeholder' => 'Barangay',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- CITY -->
            <div class="form-group">
                <?php Form::label('city *' , 'city')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('city' , '' ,[
                        'id' => 'city',
                        'placeholder' => 'City',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- Province -->
            <div class="form-group *">
                <?php Form::label('province' , 'province')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::text('province' , '' ,[
                        'id' => 'province',
                        'placeholder' => 'Province',
                        'required' => '' ,
                        'class' => 'input100'
                    ])?>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <span class="lnr lnr-user"></span>
                    </span>
                </div>
            </div>

            <!-- POSITION -->
            <div class="form-group *">
                <?php Form::label('position' , 'position')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php Form::select('position' , [
                        'left' => 'LEFT' ,
                        'right' => 'RIGHT'
                    ] , $position , [
                        'class' => 'input100'
                    ])?>
                </div>
            </div>

            <!-- VRANCH -->
            <div class="form-group *">
                <?php Form::label('Branch*' , 'branch')?>
                <div class="wrap-input100 validate-input m-b-16">
                    <?php
                        Form::select('branch' ,$branchList , 8 , [
                            'class' => 'input100',
                            'required' => ''
                        ])
                    ?>
                </div>
            </div>

            <div class="container-login100-form-btn p-t-25">
                <button type="submit" class="login100-form-btn">
                    Submit
                </button>
            </div>
        <?php Form::close()?>
    </div>
</div>
<?php endbuild()?>


<?php occupy('templates.baselayout')?>