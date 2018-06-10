@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-20 mt-20">
        <div class="content" id="course-enroll-app">
            <div class="columns">
                <div class="column is-1"></div>
                <div class="column">
                    <div class="content pt-40">
                        <div class="page-title-wrap  mt-20 is-paddingless">
                            <h1 class="is-size-1-desktop is-size-1-mobile mt-0">
                                Apply Online: {{ $course->name }}
                            </h1>
                            <h2><span class="has-text-danger">({{ $course->brand }})</span> - Intake Date: {{ $intakeItem->scheduled->format('d-M-Y') }}</h2>
                        </div>
                        @if(!session('user_data.uuid'))
                            <hr>
                        <el-form ref="user" :model="user" label-width="100px" class="is-invisible" id="course-enroll-app-form">
                            <div class="columns" v-show="hasAccount">
                                <div class="column">
                                    <el-form-item label="Please Choose" class="full-width">
                                        <el-select v-model="hasAccount" placeholder="Please choose your status" class="full-width">
                                            <el-option label="I already have an account" :value="true"></el-option>
                                            <el-option label="I don't have account" :value="false"></el-option>
                                        </el-select>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="columns" v-show="hasAccount">
                                <div class="column">
                                    <el-form-item label="Your Email">
                                        <el-input v-model="user.email" placeholder="Your Email"></el-input>
                                    </el-form-item>
                                    <p class="has-text-success has-text-centered" v-if="emailField.infoMsg2.length>0" v-html="emailField.infoMsg2"></p>
                                </div>
                                <div class="column">
                                    <el-form-item label="Password">
                                        <el-input v-model="user.password" placeholder="Password"></el-input>
                                    </el-form-item>
                                </div>
                                <div class="column">
                                    <el-form-item>
                                        <el-button :loading="isDoingLogin" icon="el-icon-arrow-right" type="primary" @click="onSubmit">Log Me In</el-button>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="columns" v-show="!hasAccount">
                                <div class="column"  v-if="!showVerificationField">
                                    <el-form-item label="Your Name">
                                        <el-input v-model="user.name" placeholder="Your Name"></el-input>
                                    </el-form-item>
                                </div>
                                <div class="column"  v-if="!showVerificationField">
                                    <el-form-item label="Your Email" v-show="!emailField.isEmailVerified">
                                        <el-input v-model="user.email" placeholder="Your email address"></el-input>
                                    </el-form-item>
                                    <p class="has-text-danger has-text-centered" v-if="emailField.errorMsg.length>0">@{{ emailField.errorMsg }}</p>
                                    <p class="has-text-success has-text-centered" v-if="emailField.infoMsg.length>0">@{{ emailField.infoMsg }}</p>
                                </div>
                                <div class="column" v-if="showVerificationField">
                                    <el-form-item label="Code">
                                        <el-input v-model="user.verificationCode" placeholder="Your verification code"></el-input>
                                    </el-form-item>
                                    <p class="has-text-link has-text-centered" v-if="emailField.infoMsg.length>0">@{{ emailField.infoMsg }}</p>
                                    <p class="has-text-danger has-text-centered" v-if="verificationField.errorMsg.length>0">@{{ verificationField.errorMsg }}</p>
                                </div>
                                <div class="column" v-if="showVerificationField">
                                    <el-form-item label="CAPTCHA">
                                        <el-input v-model="user.captcha" placeholder="Enter code below"></el-input>
                                    </el-form-item>
                                    <p class="has-text-centered" v-show="!captchaMatched">
                                        <span class="captcha-box">CAPTCHA: @{{ captcha }}</span>
                                    </p>
                                </div>
                                <div class="column">
                                    <el-form-item v-if="!showVerificationField">
                                        <el-button :loading="emailField.isVerifyingEmail" icon="el-icon-circle-check" type="success" @click="getVerificationCode">
                                            Verify My Email
                                        </el-button>
                                    </el-form-item>
                                    <el-form-item v-if="showVerificationField">
                                        <el-button :disabled="!captchaMatched" :loading="verificationField.isVerifyingCode" icon="el-icon-circle-check" type="primary" @click="verifyCode">
                                            Verify My Code
                                        </el-button>
                                    </el-form-item>
                                </div>
                            </div>
                        </el-form>
                        @endif

                        <form action="" method="post" enctype="multipart/form-data" class="{{ session('user_data.uuid')?null:'is-invisible' }}">
                            @csrf
                            <input id="current-intake-item" type="hidden" name="enroll[intake_item]" value="{{ $intakeItem->id }}">
                            <input id="current-course-id" type="hidden" name="enroll[course_id]" value="{{ $course->uuid }}">
                            <input type="hidden" name="student[user_id]" value="{{ session('user_data.uuid') }}">
                            <input id="current-group-id" type="hidden" name="student[agent_id]" value="{{ isset($dealer)&&$dealer ? $dealer->id : 0  }}">
                            <hr>
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">1: Personal Details(as they appear on your passport)</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','family_name',true,($studentProfile ? $studentProfile->family_name : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','given_name',true,($studentProfile ? $studentProfile->given_name : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','previous_name',false,($studentProfile ? $studentProfile->previous_name : null)) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','birthday',true,($studentProfile ? $studentProfile->birthday : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','gender',[1=>'Male',0=>'Female'],($studentProfile ? $studentProfile->gender : 1)) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','country_of_citizenship',true,($studentProfile ? $studentProfile->country_of_citizenship : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','passport',true,($studentProfile ? $studentProfile->passport : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','visa_category',false,($studentProfile ? $studentProfile->visa_category : null)) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','disability_required',['NO','YES'],($studentProfile ? $studentProfile->disability_required : 0),true,'Do you have a disability for which additional assistance may be required?') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('student','disability_required_file',false,'If YES, please attach a separate sheet outlining this disability and assistance required') }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">2: Contact Details</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','home_address',true, ($studentProfile ? $studentProfile->home_address : null), null,'Home Address(in home country)') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','province',true, ($studentProfile ? $studentProfile->province : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','post_code',false, ($studentProfile ? $studentProfile->post_code : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','country',false,($studentProfile ? $studentProfile->country : null)) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','current_address', true, ($studentProfile ? $studentProfile->current_address : null)) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','province_current',true, ($studentProfile ? $studentProfile->province_current : null), null,'Province') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','post_code_current',false, ($studentProfile ? $studentProfile->post_code_current : null), null,'Post Code') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','country_current',false, ($studentProfile ? $studentProfile->country_current : null), null,'Country') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','current_residing',['Australia','Offshore'],($studentProfile ? $studentProfile->current_residing : 1),true) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','is_pr',['No','Yes'],($studentProfile ? $studentProfile->is_pr : 0),true,'Are you a permanent resident or citizen of Australia?') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','document_evidence',true, ($studentProfile ? $studentProfile->document_evidence : null), null,'If YES, please attach document evidence. If NO, please provide copies of current visa and evidence of your current OSHC.') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','telephone_country_code',true,($studentProfile ? $studentProfile->telephone_country_code : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','area_code',true, ($studentProfile ? $studentProfile->area_code : null)) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','phone_number', true, ($studentProfile ? $studentProfile->phone_number : null)) }}
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">3:English Proficiency</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','form_of_test',['IELTS','TOEFL','CAE','PTE Academic','Other'],null,true) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','form_of_test_other',false, null, null,'What test if you choose "Other"') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','test_score') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','test_taken_date',true, null, 'Required: dd/mm/yyyy') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','english_proficiency_certificate') }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">4: Personal Details(as they appear on your passport)</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','course_1') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','institute_1') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_commenced') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_completed') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','course_2') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','institute_2') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_commenced_2') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_completed_2') }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">5: Would you like to seek exemptions based on your previous qualifications and/or working experience?</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','applying_exemptions',['NO','YES'],null,true,'Are you applying for exemptions??') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('student','applying_exemptions_files',false,'If Yes, please complete the application form for exemption with your supporting documents such as unit outline and qualifications before commencement of your desired course(s).') }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">6: Declaration</h2>
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
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">7: How did you hear about us?</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','heard_from',['Government Website','Advertisements','Friends/Relatives','Agent','Other'],null,true) }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">8: Would you like to authorize any education agent to represent you in relation to this application:</h2>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('enroll','authorize_to_agent',['NO','YES, please fill in the question No.9 below'],null,true) }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">9: Details of the Agent</h2>
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
                                <h2 class="is-size-4 has-text-grey">10: If you have our voucher?</h2>
                            </div>
                            <div class="columns">
                                <div class="column is-8">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('enroll','voucher',false,null,null,env('APP_NAME').' Voucher Number') }}
                                </div>
                                <div class="column">

                                </div>
                            </div>
                            <div class="row">
                                <div class="field">
                                    <div class="control">
                                        <br>
                                        <button class="button is-large is-link">Apply Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <blockquote class="mt-10">Note: students are encouraged to contact {{ env('APP_NAME') }} Marketing team for exact timetable and training arrangement.</blockquote>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="column is-1"></div>
            </div>
        </div>
    </div>
@endsection