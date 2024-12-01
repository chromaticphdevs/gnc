<?php build('content')?>
<div id="screenCover">
   <div id="screenCoverBody" style='text-align:center;margin-top:300px;background:#fff;padding:25px'></div>
</div>
<div class="col-md-12">
    <?php if(!isset($networkPayload)) :?>
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Verify Email')) ?>
            <div class="card-body">
                <?php Flash::show()?>
                <?php
                    Form::open([
                        'method' => 'post'
                    ]); 
                ?>
                    <div class="form-group">
                        <?php
                            Form::label('Email *');
                            Form::text('email' , '' , [
                                'class' => 'form-control',
                                'requried' => true
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Loan Processor');
                            Form::text('loan_processor' , '' , [
                                'class' => 'form-control',
                                'placeholder' => 'Loan Processor Username' 
                            ]);
                        ?>
                    </div>
                <?php
                    Form::submit('verify_email' , 'Verify Email' , ['class' => 'btn btn-primary']);
                    Form::close();
                ?>
            </div>
        </div>
    <?php else:?>
        <div class="card" id="agreement">
            <?php echo wCardHeader(wCardTitle(WordLib::get('loanAgreement')))?>
            <div class="card-body">
                <?php grab('_documents/loan_first_step')?>
                <div id="cboxagreementcontainer">
                    <label for="cboxagreement">
                        <input type="checkbox" id="cboxagreement">
                        I have read and agree to this <a href="/DocumentController/initialAgreement" target="_blank"><?php echo WordLib::get('loanAgreement')?></a>
                    </label>

                    <label for="cboxprivacylaw">
                        <input type="checkbox" id="cboxprivacylaw">
                        I agree and I waive my data privacy act law
                    </label>
                </div>
            </div>
        </div>
        <div class="card" id="registrationForm">
            <?php echo wCardHeader(wCardTitle('Register User')) ?>
            <div class="card-body">
                <?php Flash::show()?>
                <?php
                    $isVerifiedEmail = $_GET['isVerifiedEmail'] ?? '';
                    $isVerifiedEmail = unseal($isVerifiedEmail);

                    $email = $isVerifiedEmail['email'];
                    $date = $isVerifiedEmail['date'];

                    if($date != date($date)) {
                        dump("Expired Registration Link.");
                    }

                    Form::open([
                        'method' => 'post',
                        'action' => '',
                        'id' => 'registrationForm'
                    ]);

                    Form::hidden('position' , $networkPayload['position'] , [
                        'class' => 'form-control'
                    ]);
                ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('First Name *');
                                    Form::text('firstname' , '' , [
                                        'class' => 'form-control',
                                        'required' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                            <?php
                                Form::label('Last Name *');
                                Form::text('lastname' , '' , [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Username *');
                                    Form::text('username' , '' , [
                                        'class' => 'form-control',
                                        'required' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php Form::label('Password *');?>
                                <?php
                                    Form::password('password' , '' , [
                                        'class' => 'form-control',
                                        'id'    => 'passwordText'
                                    ]);
                                ?>
                                <label for="showPassword">
                                    <input type="checkbox" id="showPassword">
                                    Show Password
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Email *');
                                    Form::text('email' , $email , [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                    Form::label('Phone Number');
                                    Form::text('mobile' , '' , [
                                        'class' => 'form-control'
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Address');
                            Form::text('address' , '' , [
                                'class' => 'form-control',
                                'required' => true
                            ]);
                        ?>
                    </div>

                    <!-- CUSTOMER SPECIFIC INPUT -->
                    <div id="id_upline_and_direct_sponsor">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        Form::label(WordLib::get('directSponsor'));
                                        Form::hidden('direct_sponsor' , $networkPayload['user_id']);
                                        Form::text('' , $referral->firstname. ' ' . $referral->lastname, [
                                            'class' => 'form-control',
                                            'readonly' => true
                                        ]);
                                        Form::small(WordLib::get('directSponsor'). ' Username');
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                        Form::label(WordLib::get('upline'));
                                        Form::hidden('upline' , $upline->id , [
                                            'class' => 'form-control'
                                        ]);
                                        Form::text('' , $upline->firstname . ' ' .$upline->lastname , [
                                            'class' => 'form-control',
                                            'readonly' => true
                                        ]);
                                        Form::small(WordLib::get('upline'). ' Username');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php if(isset($loanProcessor)) :?>
                        <div class="form-group">
                            <?php 
                                Form::label(WordLib::get('loanProcessor'));
                                Form::hidden('loan_processor_id' , $loanProcessor->id , [
                                    'class' => 'form-control'
                                ]);
                                Form::text('', $loanProcessor->firstname . ' ' .$loanProcessor->lastname, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ])
                            ?>
                        </div>
                        <?php endif?>
                    </div>

                    <label for="#">Important ! Write your signature here.</label>
                    <div class="mb-4">
                        <canvas id="esig"></canvas>
                        <a href="#" id="sigClear">Clear Signature</a>
                    </div>

                    <?php Form::submit('register_user' , 'Register' , ['class' => 'btn btn-primary', 'id' => 'btnRegistration']); ?>
                <?php Form::close()?>
            </div>
        </div>
    <?php endif?>


    <div class="text-center mt-5">
        <p>Already have account? <a href="/users/login">Login here.</a></p>
    </div>
    
</div>
<?php endbuild()?>
<?php build('scripts') ?>
  <!-- https://github.com/szimek/signature_pad -->
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
  <script>
    $(document).ready(function(){
        $('#screenCover').hide();
        $('#cboxagreement').parent().hide();
        $('#cboxprivacylaw').parent().hide();
        $('#registrationForm').hide();

        const canvas = document.getElementById("esig");
        const signaturePad = new SignaturePad(canvas, {
            minWidth: 1,
            maxWidth: 3,
            penColor: "rgb(0,0,0)"
        });

        signaturePad.addEventListener("beginStroke", () => {
            console.log("Signature started");
        }, { once: true });

        $('#showPassword').click(function(){
            // alert('hey');
            if($('#passwordText').attr('type') == 'password') {
                $('#passwordText').attr('type', 'text');
            } else {
                $('#passwordText').attr('type', 'password');
            }
        });

        $('#cboxagreement').add('#cboxprivacylaw').on('change', showRegistrationForm)
        
        $("#sigClear").click(function(){
            signaturePad.clear();
        });

        $("#registrationForm").on('submit', function(e) {
            e.preventDefault();
            let registrationData = {
                position : $('input[name="position"]').val(),
                firstname : $('input[name="firstname"]').val(),
                lastname : $('input[name="lastname"]').val(),
                username : $('input[name="username"]').val(),
                password : $('input[name="password"]').val(),
                email : $('input[name="email"]').val(),
                mobile : $('input[name="mobile"]').val(),
                address : $('input[name="address"]').val(),
                direct_sponsor : $('input[name="direct_sponsor"]').val(),
                upline : $('input[name="upline"]').val(),
                loan_processor_id : $('input[name="loan_processor_id"]').val(),
                register_user : 'Register'
            };

            if(signaturePad.isEmpty()) {
                alert('Signature cannot be empty!');
                return;
            }

            $('#btnRegistration').hide();

            $('#screenCoverBody').html(
                `<h1>Trying to create your account..</h1>
                <i class='fa fa-spinner text-primary' style='font-size:50pt'> </i>
                <p style='margin-top:20px'> You will be redirected to your account once account is ready..<p>
                `
            );

            $('#screenCover').show();

            $('html, body').animate({
                scrollTop: $("#registrationForm").offset().top
            }, 1300);

            $.ajax({
                type: 'POST',
                url: get_url('/UserController/referralRegistration'),
                data: registrationData,
                success : function(response) {
                    let responseData = JSON.parse(response);

                    if(responseData['status'] == false) {
                        let messageString = '<h1>Unable to register</h1>';
                        for(let i in responseData['message']) {
                            messageString += `<p>${responseData['message'][i]}<p>`;
                            messageString += '\n';
                        }
                        setTimeout(function() {
                            $('#screenCoverBody').html(messageString);
                            $('#screenCoverBody').append(
                                `<div><button id="tryAgain"> Try Again </button></div>`
                            );
                        }, 3000);
                    } else {
                        let signatureImageEncoded = signaturePad.toDataURL();

                        $.ajax({
                            url : get_url('API_ImageUploaderController/uploadImage'),
                            type : 'POST',
                            data : {
                                sourceFor : 'esig',
                                userId : responseData['data']['userId'],
                                image : signatureImageEncoded,
                            },
                            success : function(response) {
                                $.ajax({
                                    url : get_url('API_UserMeta/saveLoanAmount'),
                                    type : 'POST',
                                    data : {
                                        loanAmount : $("#loan_amount").val(),
                                        userId : responseData['data']['userId']
                                    },
                                    success : function(response) {
                                        alert('Registration Successfull');
                                        window.location.href = '/UserIdVerification/upload_id_html';
                                    }
                                });
                            }
                        });
                    }
                    
                }
            })
        });

        $(document).on('click', '#tryAgain', tryAgain);

        function showRegistrationForm() {
            if($('#cboxagreement').is(':checked') && $('#cboxprivacylaw').is(':checked')) {
                if($('#loan_amount').val() < 500) {
                    return alert("Amount is too low for cash advance");
                } else if($('#loan_amount').val() > 300000) {
                    return alert("Amount is big for cash advance");
                }
                if(confirm('Continue your registration')) {
                    $("#agreement").hide();
                    $('#registrationForm').show();
                }
            }
        }

        $("#loan_amount").keyup(function(e){
            let val = $(this).val();

            if(val >= 500 && val < 300000) {
                $('#cboxagreement').parent().show();
                $('#cboxprivacylaw').parent().show();
            } else {
                $('#cboxagreement').parent().hide();
                $('#cboxprivacylaw').parent().hide();
            }
            
        });
        function tryAgain() {
            $("#screenCover").hide();
            $("#screenCoverBody").html('');
            $("#btnRegistration").show();
        }
    });
  </script>
<?php endbuild()?>

<?php build('headers')?>
<style>
    #esig{
        border: 1px solid #000;
        width: 100%;
        max-width: 350px;
    }
    #documentAgreementLoan p, #documentAgreementLoan ol li {
        font-size: 8pt;
    }
    #documentAgreementLoan section{
        margin-bottom: 25px;
    }
    #documentAgreementLoan section h3{
        font-size: .95em;
    }
    #documentAgreementLoan section h3::before {
        content: ' ';
    }

    #cboxagreementcontainer {
        text-align: center;
        margin-top: 30px;
    }

    #screenCover{
        height: 300vh;
        width: 100%;
        background-color: rgba(0,0,0, .6);
        z-index: 1000;
        position: absolute;
    }
</style>
<link rel="stylesheet" href="<?php echo URL.'/public/js/esig/esig.css'?>">
<?php endbuild()?>
<?php occupy('templates/baselayout')?>