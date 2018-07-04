
<div class="row">
    <h2 class="is-size-4 has-text-grey">6: How did you hear about us?</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','heard_from',['Government Website','Advertisements','Friends/Relatives','Agent','Other'],null,true) }}
    </div>
</div>

<div class="row">
    <h2 class="is-size-4 has-text-grey">7: Would you like to authorize any education agent to represent you in relation to this application:</h2>
</div>

<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('enroll','authorize_to_agent',['NO','YES, please fill in the question No.9 below'],null,true) }}
    </div>
</div>

<div class="row">
    <h2 class="is-size-4 has-text-grey">8: Details of the Agent</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','agent_name',false,(isset($dealer)&&$dealer ? $dealer->name : null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','contact_person',false) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','telephone',false,(isset($dealer)&&$dealer ? $dealer->phone : null)) }}
    </div>
</div>
<div class="columns">
    <div class="column is-8">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','agent_email',false,(isset($dealer)&&$dealer ? $dealer->email : null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','agent_fax',false,(isset($dealer)&&$dealer ? $dealer->fax : null)) }}
    </div>
</div>

<div class="row">
    <h2 class="is-size-4 has-text-grey">9: If you have our voucher?</h2>
</div>
<div class="columns">
    <div class="column is-8">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','voucher',false,null,null,env('APP_NAME').' Voucher Number') }}
    </div>
    <div class="column">

    </div>
</div>

<div class="row">
    <h2 class="is-size-4 has-text-grey">10: Declaration</h2>
</div>
<div class="row">
    <blockquote>
        <p>{{ env('APP_NAME') }} is committed to ensuring the privacy of all information it collects. Personal information supplied to the institute will only be used for administrative and educational purposes of this institution.
        </p><p>
            As student applying for enrolment at {{ env('APP_NAME') }}, I understand that:
        </p>
        <ul>
            <li>
                <p>
                    {{ env('APP_NAME') }} may be required to disclose this information to the Department of Immigration and Border Protection(DIBP), to the Department of Education(DE) or to Australian Taxation Office(ATO) or any other Australian government agency on demand;
                </p>
            </li>
            <li>
                <p>{{ env('APP_NAME') }} will store the information securely in its Students Information Management System;
                </p>
            </li>
            <li>
                <p>Personal information collected will be disclosed to third parties only with the written consent of the person concerned, unless otherwise stated by law.
                </p>
            </li>
        </ul>
        <p>I declare, that all the information supplied herein is correct and complete. I acknowledge, that the submission of incorrect or incomplete information may result in a cancellation of enrolment at any time. I recognize, that it is my responsibility to provide all necessary certified documents as evidence of my qualifications. I authorize, APEI to obtain further information with respect to my application and, if necessary, provide information to educational institutions.
        </p>
        <p>
        <div class="field">
            <div class="control">
                <label class="checkbox">
                    <input type="checkbox" name="declare_all">
                    *<span class="has-text-link">I declare, that all</span>
                </label>
            </div>
        </div>
        </p>
    </blockquote>
    <br>
</div>