<div class="row">
    <h2 class="is-size-4 enrol-subtitle">6: {{ trans('enrolment.How_did_you_hear_about_us') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','heard_from',[trans('general.Government_Website'),trans('general.Advertisements'),trans('general.Friends_Relatives'),trans('general.Agent'),trans('general.Other')],null,true) }}
    </div>
</div>

<div class="row">
    <h2 class="is-size-4 enrol-subtitle">7: {{ trans('enrolment.Authorize_any_education') }}</h2>
</div>

<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('enroll','authorize_to_agent',[trans('general.no'),trans('general.fill_9_below')],(isset($dealer)&&$dealer->id?1:0),true) }}
    </div>
</div>

<div class="row">
    <h2 class="is-size-4 enrol-subtitle">8: {{ trans('enrolment.Details_of_the_Agent') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','agent_name',false,(isset($dealer)&&$dealer ? $dealer->name : null),null,null, (isset($dealer)&&$dealer->name)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','contact_person',false,(isset($dealer)&&$dealer ? $dealer->contact_person : null),null,null, (isset($dealer)&&$dealer->contact_person)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','telephone',false,(isset($dealer)&&$dealer ? $dealer->phone : null),null,null, (isset($dealer)&&$dealer->phone)) }}
    </div>
</div>
<div class="columns">
    <div class="column is-8">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','agent_email',false,(isset($dealer)&&$dealer ? $dealer->email : null),null,null, (isset($dealer)&&$dealer->email)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','agent_fax',false,(isset($dealer)&&$dealer ? $dealer->fax : null),null,null, (isset($dealer)&&$dealer->fax)) }}
    </div>
</div>

<div class="row">
    <h2 class="is-size-4 enrol-subtitle">9: {{ trans('enrolment.If_you_have_our_voucher') }}</h2>
</div>
<div class="columns">
    <div class="column is-8">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','voucher',false,(isset($dealer)&&$dealer ? $dealer->group_code : null), null, null, (isset($dealer)&&$dealer),null,null, (isset($dealer)&&$dealer->group_code)) }}
    </div>
    <div class="column">

    </div>
</div>

<div class="row">
    <h2 class="is-size-4 enrol-subtitle">10: {{ trans('general.Required_files') }}</h2>
    <div class="columns">
        <div class="column m-19" id="passportInputWrap" style="border:solid 1px #fff;">
            {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('passport_first_page_image',false,trans('enrolment.passport_first_page_image')) }}
            @if($studentProfile && $studentProfile->passport_first_page_image)
                <p id="existed-passport-file-link"><a target="_blank" href="{{ asset('/storage/'.$studentProfile->passport_first_page_image) }}">{{ trans('enrolment.my_passport_first_page_image') }}</a></p>
            @endif
        </div>
        <div class="column m-19"  id="certInputWrap" style="border:solid 1px #fff;">
            {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('english_test_certificate_image',false,trans('enrolment.english_test_certificate_image')) }}
            @if($studentProfile && $studentProfile->english_test_certificate_image)
                <p id="existed-english-test-file-link"><a target="_blank" href="{{ asset('/storage/'.$studentProfile->english_test_certificate_image) }}">{{ trans('enrolment.my_english_test_certificate_image') }}</a></p>
            @endif
        </div>
    </div>
</div>
<br>
<div class="row">
    <h2 class="is-size-4 enrol-subtitle mb-0">11: {{ trans('general.Declaration') }}</h2>
    <blockquote>
        <p>{{ env('APP_NAME') }} is committed to ensuring the privacy of all information it collects. Personal information supplied to the institute will only be used for administrative and educational purposes of this institution.
        </p>
        <p>
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
        <p>
            I declare, that all the information supplied herein is correct and complete. I acknowledge, that the submission of incorrect or incomplete information may result in a cancellation of enrolment at any time. I recognize, that it is my responsibility to provide all necessary certified documents as evidence of my qualifications. I authorize, APEI to obtain further information with respect to my application and, if necessary, provide information to educational institutions.
        </p>
        <div class="field">
            <div class="control">
                <label class="checkbox">
                    <input type="checkbox" v-model="isAgreementChecked" name="declare_all">
                    *<span class="has-text-link">I declare, that all</span>
                </label>
            </div>
        </div>
    </blockquote>
    <br>
</div>