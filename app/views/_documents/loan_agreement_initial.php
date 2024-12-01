<?php build('content') ?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle(WordLib::get('cashAdvance')))?>
        <div class="card-body">
            <div id="documentAgreementLoan">
                <section>
                    <h3>Acknowledgement</h3>
                    <p>
                        Hereby, the Parties agree that the Lender will lend 5,000.00 pesos to the Borrower as
                        per this Agreement. <b>Automatically you will be a co-maker of your <?php echo WordLib::get('directSponsor')?> and 
                        your immediate refferals will be your co-makers as well.</b>
                    </p>
                </section>

                <section>
                    <h3>Auto Renewal</h3>
                    <p>- The loan is automatically renewed unless the parties submits a written request to cancel the renewal
                    10 days before the end of the term.</p>
                    <table class="table table-bordered table-sm" style="font-size: .80em;">
                        <tr>
                            <td>1st</td>
                            <td>10,000.00</td>
                        </tr>
                        <tr>
                            <td>2nd</td>
                            <td>20,000.00</td>
                        </tr>
                        <tr>
                            <td>3rd</td>
                            <td>30,000.00</td>
                        </tr>
                        <tr>
                            <td>4th</td>
                            <td>40,000.00</td>
                        </tr>
                        <tr>
                            <td>5th</td>
                            <td>50,000.00</td>
                        </tr>
                        <tr>
                            <td>6th</td>
                            <td>60,000.00</td>
                        </tr>
                        <tr>
                            <td>7th</td>
                            <td>70,000.00</td>
                        </tr>
                        <tr>
                            <td>8th</td>
                            <td>80,000.00</td>
                        </tr>
                        <tr>
                            <td>9th</td>
                            <td>90,000.00</td>
                        </tr>
                    </table>

                    <h3>Maximum Loan is Php 100,000.00</h3>
                </section>


                <section>
                    <h3>Payment</h3>
                    <p>
                        Hereby, the Parties agree that the payment will continue until the date of the Last Payment
                    </p>
                </section>

                <section>
                    <h3>Promise To Pay</h3>
                    <p>
                        The Parties hereby agree that the Borrower promises to pay the Lender
                    </p>
                </section>

                <section>
                    <h3>Amendments</h3>
                    <p>
                        The Parties agree that any amendments made to this Agreement must be in writing
                        where they must be signed by both Parties to this Agreement
                    </p>
                    <p>As such, any amendments made by the Parties will be applied to this Agreement</p>
                </section>

                <section>
                    <h3>Assignment</h3>
                    <p>
                        The Parties hereby agree not to assign any of the responsibilities in this Agreement to a
                        third party unless consented to by both Parties in writing.
                    </p>
                </section>

                <section>
                    <h3>Entire Agreement</h3>
                    <p>
                        This Agreement contains the entire agreement and understanding among the Parties
                        hereto with respect to the subject matter hereof, and supersedes all prior agreements, understandings, inducements and conditions, express or implied, oral or written, of any
                        nature whatsoever with respect to the subject matter hereof. The express terms hereof
                        control and supersede any course of performance and/or usage of the trade inconsistent
                        with any of the terms hereof.
                    </p>
                </section>

                <section>
                    <h3>Ownership </h3>
                    <p>
                        The Parties agree that this Agreement is not transferable unless a written consent is
                        provided by both Parties of this Agreement
                    </p>
                </section>

                <section>
                    <h3>Co Maker Responsibility</h3>
                    <p>
                        A co-maker is a person who is legally required to pay for a loan and related fees if the borrower fails
                        to do so.This assures the lender that the loan will be paid no matter what happens. Signing this Agreement paper means that the co maker understood their responsibility once the
                        borrower fails to pay the loan
                    </p>
                </section>

                <section>
                    <h3>Responsibilities</h3>
                    <p>
                        Failure to fulllfill obligation Legal Fees Filing fee and collection Fees will be applied.
                    </p>
                </section>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?>
    <style>
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
    </style>
<?php endbuild()?>
<?php occupy('templates/baselayout') ?>