<div class="word-page-style">
    <p style="font-weight: bold;">Declaration and Acceptance of Offer
    </p>

    <p>
        I, <span style="text-decoration: underline;">&nbsp;&nbsp;{{ $student->name }}&nbsp;&nbsp;</span> have read and understood the pre-enrolment information about the course(s) I am applying for. I have also read and understand the information provided in the Student Handbook regarding SIIT Policies and Procedures and the Student Code of Conduct. I acknowledge that this information has also been made available to me through the SIIT website and/or by emails.
    </p>
    <p>
    I understand that:
    </p>
    <p style="padding-left: 16px;">
    a.	I am required to pay the course fee as per the payment schedule on page No.3.
    </p>
    <p style="padding-left: 16px;">
    b.	The Information Program organised at SIIT is compulsory and is held before the course commencement date specified in the Letter of Offer.
    </p>
    <p style="padding-left: 16px;">
    c.	I am required to abide by the rules and regulations of SIIT as is indicated in the pre-enrolment information (Student Handbook and this Letter).
    </p>
    <p style="padding-left: 16px;">
        d.	I must provide original academic transcripts and other required documents to SIIT to be sighted, copied and recorded for future reference.
    </p>
    <p style="padding-left: 16px;">
        e.	This Offer of Enrolment is valid for the course commencement stated in this Letter of Offer. Deferring my studies to a later date might not be granted and could result in a change to the tuition fees.
    </p>
    <p style="padding-left: 16px;">
        f.	The course-related fees may change without prior notice.
    </p>
    <p style="padding-left: 16px;">
        g.	The information that I have provided to SIIT may be made available to Commonwealth and State agencies pursuant to obligations under legislation.
    </p>
    <p style="padding-left: 16px;">
        h.	I am required to notify SIIT of any change of contact details including postal address, e-mail address, contact phone number and emergency contact details within 10 days of the change occurring (including name, relationship and contact phone and address) during my enrolment at SIIT.
    </p>
    <p style="padding-left: 16px;">
        i.	I have read, understand and accept the refund policy.
    </p>
    <p style="padding-left: 16px;">
        j.	This agreement, and the availability of complaints and appeals processes, does not remove the right for me to take action under Australia’s consumer protection laws.
    </p>
    <p style="padding-left: 16px;">
        k.	I must attend classes and complete all assigned class work to ensure a positive outcome.
    </p>
    <p style="padding-left: 16px;">
        l.	I must make satisfactory course progress.
    </p>
    <p style="padding-left: 16px;">
        m.	I must maintain adequate arrangements for health insurance during my stay in Australia and meet the costs of Overseas Student Health Cover (OSHC) to cover the period of my enrolment at SIIT. SIIT will try, but is under no obligation, to remind me of the renewal of my OSHC. (international students only)
    </p>
    <p style="padding-left: 16px;">
        n.	I understand that if I have any school-aged dependents accompanying me to Australia, they must attend school and that I may be required to pay full fees if they are enrolled either in a government or non-government school. (international students only)
    </p>
    <p style="padding-left: 16px;">
        o.	I have read and understand the refund policy which is enclosed with this Offer Acceptance form.
    </p>
    <p style="padding-left: 16px;">
        p.	If I make a payment of relevant fees without signing this offer acceptance form, I certify and confirm that I have accepted the terms & conditions as part of this offer.
    </p>
    <p>
    I hereby declare that I have read and understand all ten (10) pages of the terms and conditions of this Letter and I am willing to accept this offer.
    </p>
    <br>
    <p style="float: left;">
        Student Name (please print): <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;{{ $student->name }}&nbsp;&nbsp;&nbsp;</span>
    </p>
    <p style="float: right;">
        Date: <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;{{ date('d/m/Y') }}&nbsp;&nbsp;&nbsp;</span>
    </p>
    <br>
    @include('frontend.custom.siit.enroll.offer_letter.page_foot')
</div>