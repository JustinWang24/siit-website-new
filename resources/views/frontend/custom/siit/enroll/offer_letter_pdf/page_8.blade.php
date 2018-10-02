<div class="word-page-style">
    <h3>Declaration:</h3>
    <p>
        I hereby declare that I have read and understood all sixteen(16) pages of the terms and conditions of this Letter and I am willing to accept this offer.
    </p>
    <p>
    I hereby declare that I have read and understand all ten (10) pages of the terms and conditions of this Letter and I am willing to accept this offer.
    </p>
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
</div>