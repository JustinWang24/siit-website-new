<div class="word-page-style">
    <p>
        As an international student, I must also abide by the relevant Student Visa Conditions, as follows:
    </p>
    <ol>
        <li>I must attend and study for at least 20 hours per week as is stipulated on my student visa.</li>
        <li>I must attend at least 80% of the scheduled classes for every study period to comply with the full-time
            study load requirement of my student visa. A study period is usually 10 weeks.</li>
        <li>I must make satisfactory course progress. I can only repeat a unit of competency for a course once
            during my enrolment.</li>
        <li>I must maintain adequate arrangements for health insurance during my stay in Australia and meet the
            costs of Overseas Student Health Cover (OSHC) to cover the period of my enrolment at SIIT. SIIT will
            try, but is under no obligation, to remind me of the renewal of my OSHC.</li>
        <li>I understand that if I have any school-aged dependents accompanying me to Australia, they must
            attend school and that I may be required to pay full fees if they are enrolled either in a government or
            non-government school.</li>
        <li>I cannot transfer to another institution within the first 6 months of my arrival in Australia. If my program
            is of less than 12 months duration, I must remain at SIIT for the duration of the program. The
            Department of Immigration and Border Protection (DIBP) may approve a transfer which does not meet
            these rules only in exceptional circumstances.</li>
        <li>I understand that the Australian government legislation restricts SIIT from enrolling transferring
            students from other registered training organisations, prior to the student completing 6 months of their
            principal course of study with the original Registered Training Organisation.</li>
        <li>I understand that in accordance with the Education Services for Overseas Students (ESOS) Act 2000,
            SIIT is required to advise the Department of Immigration and Border Protection (DIBP) if I do not meet
            any of these conditions.</li>
    </ol>
    <br>
    <p><strong>Declaration:</strong></p>
    <p>I hereby declare that I have read and understood all sixteen(16) pages of the terms and conditions of this Letter and I
        am willing to accept this offer.</p>
    <br>
    <p style="float: left;">
        Name (print): <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;{{ $student->name }}&nbsp;&nbsp;&nbsp;</span>
    </p>
    <p style="float: right;">
        Date: <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;{{ date('d/m/Y') }}&nbsp;&nbsp;&nbsp;</span>
    </p>
    <table style="border: none;">
        <tr>
            <td>
                <p>&nbsp;</p>
                <p>Signature:</p>
            </td>
            <td><img src="{{ asset($order->getStudentSignature()) }}" style="width: 160px;margin-top: 0;"></td>
        </tr>
    </table>
    <br>
    <p>
        <strong>
            Please note that this agreement (16 pages) must be signed and returned to Sydney Institute of Interpreting and Translating
        </strong>
    </p>
    <br>
</div>