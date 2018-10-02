<div class="word-page-style">
    <p>Itemised course payment information ({{ $course->getProductName() }}):</p>
    <table style="width: 100%;border: solid 1px #000;">
        <tbody>
        <tr style="background-color: #1a6bac; color: white;">
            <td style="color: white;">Item</td>
            <td style="color: white;">Fee</td>
        </tr>
        @foreach($order->orderItems as $orderItem)
            <tr style="margin-bottom: 0.5em">
                <td><strong>Course Fees*</strong></td>
                <td>${{ number_format($orderItem->subtotal,2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Administration Fee (included in course fees, non-refundable)</td>
            <td>$300.00</td>
        </tr>
        <tr>
            <td>Course Materials Fee (included in course fees, non-refundable)</td>
            <td>$500.00</td>
        </tr>
        <tr>
            <td>First installment (prior to enrolment)</td>
            <td>$1500.00</td>
        </tr>
        <tr>
            <td>Second installment (within TWO weeks from date of commencement)</td>
            <td>$8,300.00</td>
        </tr>
        <tr>
            <td>Late payment of instalment fees – penalty (if applicable)</td>
            <td>$200.00 per week</td>
        </tr>
        <tr>
            <td>Overseas Student Health Cover (compulsory)</td>
            <td>$428.00</td>
        </tr>
        <tr>
            <td><strong>Total Fees* </strong>(including OSHC)</td>
            <td>$10228.00</td>
        </tr>
        <tr>
            <td><strong>Payment Option:</strong>Under new legislation and as part of the ESOS Framework
            and the National Code 2018, students may choose to make full payment of
            course fees prior to or at the time of enrolment. Should you wish and agree to
            pay more than the initial fee of $1500 prior to starting your course, please state
            how much you want to pay and sign in the space provided.</td></tr>
        <tr><td><strong>Other fees and charges:</strong></td></tr>
        <tr>
            <td>Change of course (fee payable upon acceptance of a change of course to a
                different discipline or level. Only applicable if a CoE was already issued for the
                previous course – <strong>non refundable)</strong></td>
            <td>$250.00</td>
        </tr>
        <tr>
            <td>Change of course (fee payable upon acceptance of a change of course to a
                different discipline or level. Only applicable if a CoE was already issued for the
                previous course – <strong>non refundable)</strong></td>
            <td>$250.00</td>
        </tr>
        <tr>
            <td>Course materials fee (initially included in the course fees, to be charged if
                student has lost or requires a second copy of the course materials).</td>
            <td>$500.00/qualification</td>
        </tr>
        <tr>
            <td>Late submission assessment fee – (if not discussed with assessor prior to
                for no more than assessment due date – extensions are accepted 2 weeks from the
                assessment due date. If later than 2 weeks, the fee will be charged).</td>
            <td>$200.00/unit of competency</td>
        </tr>
        <tr>
            <td>CRe-assessment fee (first and second attempt to one assessment are included in
                the course fees, only from the third attempt thereafter the fee will be charged)</td>
            <td>$200.00/unit of competency</td>
        </tr>
        <tr style="margin-bottom: 0.5em;">
            <td>Late assessment (if duration of course ceased and the student did not complete
                assessments within the agreed course duration).</td>
            <td>$200.00/unit of competency</td>
        </tr>

        <tr><td><strong>Recognition of Prior Learning RPL/RCC</strong></td></tr>
        <tr>
            <td>Initial interview</td>
            <td>$250.00</td>
        </tr>
        <tr>
            <td>Recognition of every unit seeking RPL</td>
            <td>$200.00/unit</td>
        </tr>
        <tr>
            <td>Credit Transfer (per qualification or unit only – as requested in the credit
                transfer application – includes verification with the issuing RTO)</td>
            <td>$200.00/qualification or unit</td>
        </tr>
        <tr style="margin-bottom: 0.5em;">
            <td>Any gap training required – to be charged at unit level</td>
            <td>Applicable subject/unit fee</td>
        </tr>

        <tr><td><strong>Re-issuing of Qualifications</strong></td></tr>
        <tr>
            <td>Re-Issue Transcript only</td>
            <td>$30.00</td>
        </tr>
        <tr>
            <td>Re-Issue Certificate only </td>
            <td>$30.00</td>
        </tr>
        <tr>
            <td>Re-issue complete Testamur (Certificate and Transcript)</td>
            <td>$60.00</td>
        </tr>
        <tr>
            <td>Postage for Certificates (if other than normal and if requested by the student)</td>
            <td></td>
        </tr>
        <tr>
            <td>Registered Mail</td>
            <td style="padding-left: 1em;">$25.00</td>
        </tr>
        <tr>
            <td>Courier</td>
            <td style="padding-left: 1em;">$40.00</td>
        </tr>

        <tr><td><strong>Other Fees:</strong></td></tr>
        <tr>
            <td>Re-issue of Student Card (non-refundable)</td>
            <td>$20.00</td>
        </tr>
        <tr>
            <td>Graduation Fee</td>
            <td>To be advised</td>
        </tr>

        </tbody>
    </table>

    @include('frontend.custom.siit.enroll.offer_letter.page_foot')
</div>
