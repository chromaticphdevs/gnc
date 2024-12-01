<div id="documentAgreementLoan">
    <section style="text-align:left; background:#C4E4FF; padding:30px;">
        <h3>Enter <?php echo WordLib::get('cashAdvance')?> Amount</h3>
        <?php
            Form::number('', '', [
                'class' => 'form-control',
                'required' => true,
                'id' => 'loan_amount',
                'style' => 'width:80%; font-size:1.6em',
                'placeholder' => '5000'
            ])
        ?>
        <p>
            This <?php echo WordLib::get('cashAdvance')?> is subject for approval.
        </p>
    </section>

    <section style="display: none;">
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
</div>