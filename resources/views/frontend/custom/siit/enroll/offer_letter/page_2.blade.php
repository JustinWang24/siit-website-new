<div class="word-page-style">
    <p>Date issued: «Issue_Date»</p>
    <p>Course payment information («Course»):</p>

    <table border="1">
        <tbody>
        <tr style="background-color: #1a6bac; color: white;">
            <td>Item</td>
            <td>Fee</td>
        </tr>
        @foreach($order->orderItems as $orderItem)
            <tr>
                <td>Course Fees*</td>
                <td>${{ number_format($orderItem->subtotal,2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p style="text-decoration: underline;font-style: italic;font-size: 9px;">*SIIT reserves the right to vary its fees and charges at any time without prior notice.</p>
    <br>
    <p><strong>Payment Method</strong>:</p>
    <p>SIIT’s bank account details for the payment of fees are as follows:</p>
    <table border="1">
        <tbody>
        <tr style="background-color: #1a6bac; color: white;">
            <td colspan="2">Account for Sydney Campus</td>
        </tr>
        <tr>
            <td>Account Name:</td>
            <td>Sydney Institute of Interpreting and Translating</td>
        </tr>
        <tr>
            <td>Bank</td>
            <td>St. George Bank Limited</td>
        </tr>
        <tr>
            <td>Bank Address:</td>
            <td>4-16 Montgomery Street, Kogarah NSW 2217</td>
        </tr>
        <tr>
            <td>BSB:</td>
            <td>112 879</td>
        </tr>
        <tr>
            <td>Account No:</td>
            <td>438 956 947</td>
        </tr>
        <tr>
            <td>SWIFT code:</td>
            <td>SGBLAU2S</td>
        </tr>
        </tbody>
    </table>
    <table border="1">
        <tbody>
        <tr style="background-color: #1a6bac; color: white;">
            <td colspan="2">Account for Brisbane/Melbourne Campus</td>
        </tr>
        <tr>
            <td>Account Name:</td>
            <td>Sydney Institute of Interpreting and Translating</td>
        </tr>
        <tr>
            <td>Bank</td>
            <td>St. George Bank Limited</td>
        </tr>
        <tr>
            <td>Bank Address:</td>
            <td>4-16 Montgomery Street, Kogarah NSW 2217</td>
        </tr>
        <tr>
            <td>BSB:</td>
            <td>112 879</td>
        </tr>
        <tr>
            <td>Account No:</td>
            <td>467 886 829</td>
        </tr>
        <tr>
            <td>SWIFT code:</td>
            <td>SGBLAU2S</td>
        </tr>
        </tbody>
    </table>


    <p>Fees can be paid using the following methods:</p>
    <ul>
        <li>Telegraphic transfer – a common method of payment used by international students. International Telegraphic Transfers will attract a AUD$20.00 processing fee.</li>
        <li>Bank deposit at any branch of the St. George bank.</li>
        <li>Online transfer to SIIT’s St. George bank account.</li>
        <li>Bank cheque made payable to Sydney Institute of Interpreting and Translating.</li>
        <li>Transfers by EFTPOS using savings or credit cards. These payment facilities are available from SIIT premises. A surcharge fee applies for credit card payments.</li>
    </ul>
    <p>To confirm payment, students are required to send to SIIT via email (<a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>), a copy of the transfer receipt, deposit slip or cheque along with your name, offer number and date of birth.</p>
    @include('frontend.custom.siit.enroll.offer_letter.page_foot')
</div>
