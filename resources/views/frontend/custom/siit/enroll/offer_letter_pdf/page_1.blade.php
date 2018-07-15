<div class="word-page-style">
    <img src="{{ asset($siteConfig->logo) }}" style="width: 160px;margin-left: -56px;margin-top: -60px;">
    <h1 style="text-align: center;">Letter of Offer</h1>
    <p><strong>Dear {{ $student->name }},</strong></p>
    <p>Thank you for your application with Sydney Institute of Interpreting and Translating (hereby referred to as {{ env('APP_NAME') }}).</p>
    <p>I am pleased to advise that you have been offered a place in the course chosen by you and as listed below. The details and terms and conditions of this offer are attached to this letter.</p>

    @foreach($order->orderItems as $orderItem)
    <table style="width: 100%;border: solid 1px #000;">
        <tbody>
            <tr>
                <td style="border-right: solid 1px #000;">Student Name:</td>
                <td style="border-right: solid 1px #000;">{{ $student->name }}</td>
                <td style="border-right: solid 1px #000;">Offer No:</td>
                <td>{{ $order->serial_number }}</td>
            </tr>
            <tr style="background-color: #ccc;">
                <td style="border-right: solid 1px #000;">Date of Birth:</td>
                <td style="border-right: solid 1px #000;">{{ $studentProfile->birthday }}</td>
                <td style="border-right: solid 1px #000;">Gender:</td>
                <td>{{ $studentProfile->gender ? 'Male': 'Female' }}</td>
            </tr>
            <tr>
                <td style="border-right: solid 1px #000;">Campus</td>
                <td style="border-right: solid 1px #000;">{{ $orderItem->operator_name }}</td>
                <td style="border-right: solid 1px #000;">Photo ID No:</td>
                <td>{{ $studentProfile->passport }}</td>
            </tr>
            <tr style="background-color: #ccc;">
                <td style="border-right: solid 1px #000;">Course:</td>
                <td colspan="3">{{ $orderItem->product->name }}</td>
            </tr>
            <tr>
                <td style="border-right: solid 1px #000;">Start Date:</td>
                <td style="border-right: solid 1px #000;">{{ $orderItem->intake_start_date }}</td>
                <td style="border-right: solid 1px #000;">Finish Date:</td>
                <td></td>
            </tr>
            <tr style="background-color: #ccc;">
                <td style="border-right: solid 1px #000;">Course Fees:</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
    @endforeach

    <p>The enrolment information contained in this letter provides you with important information regarding course arrangements, fees and charges and other relevant course information.</p>
    <p>Your enrolment is valid for the duration of the course only. Conditions apply for course extension, deferral, leave of absence and withdrawal according to {{ env('APP_NAME') }} policies and procedures.</p>
    <p>Continuing enrolment will depend on:</p>
    <ol>
        <li>Agreeing to {{ env('APP_NAME') }}’s policies and procedures and any further conditions of enrolment detailed in the “Offer Acceptance Form” attached to this Letter.</li>
        <li>Payment of tuition and non-tuition fees by the due date.</li>
    </ol>
    <p>Attached you will find the “Offer Acceptance Form”, which provides you with the terms and conditions of your enrolment. If you have paid all the relevant fees to SIIT without signing the “Offer Acceptance Form”, you are deemed to have read, understood and accepted the terms and conditions as part of this offer, therefore please ensure you read carefully through our policies and procedures before making a decision regarding payment and course enrolment.</p>
    <p>To accept SIIT’s offer of enrolment, please sign and return the attached “Offer Acceptance Form” and ensure fees are paid by <span class="has-text-danger">start date</span></p>

    <p>On receipt of a completed and signed “Offer Acceptance Form” and payment of fees, SIIT will enroll you in the course and provide you with all course information.</p>

    <p style="text-decoration: underline;font-style: italic;"><strong>Please note</strong> that this course is a short course aimed to prepare you for the examination and that it does not offer on completion any certificates or awards.</p>
    <p>We agree to deliver this course according to the pre-enrolment information provided and information in this Offer Letter.</p>
    <p>On behalf of Sydney Institute of Interpreting and Translating, I thank you for your interest in this program and extend my best wishes for your study and future career.</p>
    <p>Yours sincerely,</p>
    <br>
    <p>Qingyang WEI</p>
    <p>Course Coordinator/Principal Executive Officer</p>
    <p>Sydney Institute of Interpreting and Translating</p>
</div>
