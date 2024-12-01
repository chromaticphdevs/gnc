<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        #goodthing{
            /* background-color: red; */
        }
        
        #header{
            border-bottom: 1px solid #000;
        }

        #header h1{
            margin: 0px;;
        }

        #header p{
            margin: 0px;
        }

        li{
            margin-bottom: 10px;
        }

        .footer div {
            margin-bottom: 10px;
        }

        span{
            font-weight: bold;
            color: #db5b0d;
        }

        p{
            font-size: 8pt;
        }
        
    </style>
</head>
<body>
    <?php
        $renewalStartAmount = 0;
    ?>
    <div style="width: 500px; margin:0px auto">
        <div id="header">
            <h1>Breakthrough-E</h1>
            <p><?php echo COMPANY_DETAILS['address']?></p>
        </div>

        <div style="text-align:center;margin-bottom:30px">
            <h3><?php echo WordLib::get('cashAdvance')?> Agreement (Page 2)</h3>
        </div>

        <div id="goodthing">
            REPUBLIC OF THE PHILIPPINES	)
            _________________________	) S.S.

            <p>
                AFFIDAVIT OF INFORMED CONSENT, WAIVER <br>
                AND UNDERTAKING OF COMPLIANCE <br>
                TO THE MINIMUM QUALIFICATION STANDARDS <br>
                AND REQUIREMENTS
            </p>

            <p>
                I, <span class="badge badge-primary"><?php echo "{$borrower->firstname} {$borrower->lastname}"?></span>, of legal age, 
                single/married, Filipino, with residence and postal address at <span class="badge badge-primary"><?php echo "{$borrower->address}"?></span>, 
                after having been duly sworn to in accordance with law, hereby depose and state that:
            </p>

            <p>
                I voluntarily applied for a vacant position of ________________________, 
                with Salary Grade (SG) _ and work station at _____________________, 
                Philippine Statistics Authority (PSA), posted on ______________________ at __________________________________;
            </p>

            <p>
                I have voluntarily and personally caused the preparation of the 
                application letter or letter of intent and all the documents attached thereof;
            </p>

            <p>
                I possess the minimum qualifications of the vacant position I applied for based on 
                available authentic records and of my personal knowledge 
                to be submitted to the PSA prior to the issuance of the appointments as follows:
            </p>

            <p>
                Documents for verification by PSA such as Birth Certificate and Marriage Certificate;
                Negative Drug Test results;
                Statement of Assets, Liabilities and Net Worth (SALN);
                Diploma; and
                Certificate of Employment/s (for applicants with work experience).
            </p>

            <p>
                Moreover, I will accept any action, by the duly constituted National/Regional 
                Office Human Resource Merit Promotion and Selection Board (N/RO-HRMPSB) and/or 
                the National Statistician and Civil Registrar General (NSCRG), to my application and documents thereof; 
            </p>

            <p>
                I submit myself to the hiring processes and requirements including 
                the schedules of interviews and submission of such documents deemed necessary 
                imposed by the PSA through its duly constituted N/RO-HRMPSB in accordance with 
                applicable polices by the Civil Service Commission (CSC) and existing laws, rules and regulations;
            </p>

            <p>
                I voluntarily authorize, allow or permit the PSA through its NSCRG and/or the duly 
                constituted N/RO-HRMPSB including the Secretariat thereof to undertake the following
                acts related to my application and documents supporting to my compliance of the minimum qualifications and requirements, to wit:
            </p>

            <p>
                Receive, open, view, read, appreciate, evaluate, deliberate the contents or entries in every document, 
                and act or render such decision in accordance with the policies of the CSC and applicable laws, rules and regulations;
                Reproduce or photocopy to such number of copies, and pack or wrap and transport the same to such venue/s for evaluation purposes;
                Access and request from the concerned government agency/ies and/or private 
                institutions for copy/ies of documents for purposes of verification, character and background check or investigation and due diligence;
                Submit reasonable copies to the CSC and concerned government agency/ies;
                Compile, keep, store and exercise custody ready for verification or evaluation 
                by the CSC and authorized officials of the PSA; and
                Undertake such act/s analogous to the foregoing;
            </p>

            <p>
                I hereby waive my right to privacy under Republic Act No. 10173 (Data Privacy Act of 2012) 
                and pertinent laws and consequently, I will not file  case/s against any official of the PSA,
                CSC and other government agency/ies for unintentional leak or disclosure to any party/ies or such act/s, 
                which may constitute violation/s of my rights relative to my application and documents thereof, 
                committed in good faith, in the discharge of their duties and functions;
            </p>

            <p>
                I recognize the complete authority of the NSCRG, 
                the appointing authority of the PSA,
                to reject or accept my application, and if qualified, 
                to issue appropriate appointment in accordance with CSC policies and applicable laws, 
                rules and regulations; and
            </p>

            <p>
                This affidavit is voluntarily executed in order to attest to the truthfulness of the 
                foregoing narration of facts and undertaking under pain of administrative, 
                criminal and civil liabilities, and for whatever legal purpose it may serve.
            </p>

            <p>
                IN WITNESS WHEREOF, 
                I am affixing my signature this _____ day of ___________________ 2019 in _________________________________.
            </p>

            <p>
                ____________________
                Affiant
            </p>

            <p>
                SUBSCRIBED AND SWORN TO BEFORE ME, this _____ day of __________ 
                2019 at __________________________ Philippines. 
                Affiant exhibited to me his/her valid government issued Identification (ID) with number ____________ 
                and issued on ___________________ at _______________________________.
            </p>

            <p>Doc. No. ________;</p>
            <p>Page No.__________;</p>
            <p>Book No.__________;</p>
            <p>Series of ________.</p>
        </div>
    </div>
</body>
</html>