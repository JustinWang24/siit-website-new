@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-20 mt-20">
        <div class="content">
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
                        <form action="" method="post">
                            @csrf
                            <input type="hidden" name="intake_item" value="{{ $intakeItem->id }}">
                            <input type="hidden" name="course" value="{{ $course->uuid }}">
                            <input type="hidden" name="student" value="{{ session('student.id') }}">
                            <hr>
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">1: Personal Details(as they appear on your passport)</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('family_name') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('given_name') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('previous_name',false) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('birthday') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('gender',[1=>'Male',0=>'Female']) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('country_of_citizenship') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('passport') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('visa_category',false) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('disability_required',['NO','YES'],null,true,'Do you have a disability for which additional assistance may be required?') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('disability_required_file',false,'If YES, please attach a separate sheet outlining this disability and assistance required') }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">2: Contact Details</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('home_address',true, null, null,'Home Address(in home country)') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('province') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('post_code',false) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('country',false) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('current_address') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('province_current',true, null, null,'Province') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('post_code_current',false, null, null,'Post Code') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('country_current',false, null, null,'Country') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('current_residing',['Australia','Offshore'],null,true) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('is_pr',['No','Yes'],null,true,'Are you a permanent resident or citizen of Australia?') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('email',true, null, null,'If YES, please attach document evidence. If NO, please provide copies of current visa and evidence of your current OSHC.') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('Telephone_country_code') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('area_code') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('phone_number') }}
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">3:English Proficiency</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('form_of_test',['IELTS','TOEFL','CAE','PTE Academic','Other'],null,true) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('form_of_test',false, null, null,'What test if you choose "Other"') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('test_score') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('test_taken_date',true, null, 'Required: dd/mm/yyyy') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('english_proficiency_certificate') }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">4: Personal Details(as they appear on your passport)</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('course_1') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('institute_1') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('date_commenced') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('date_completed') }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('course_2') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('institute_2') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('date_commenced_2') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('date_completed_2') }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">5: Would you like to seek exemptions based on your previous qualifications and/or working experience?</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('applying_exemptions',['NO','YES'],null,true,'Are you applying for exemptions??') }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('applying_exemptions_files',false,'If Yes, please complete the application form for exemption with your supporting documents such as unit outline and qualifications before commencement of your desired course(s).') }}
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
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('from',['Government Website','Advertisements','Friends/Relatives','Agent','Other'],null,true) }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">8: Would you like to authorize any education agent to represent you in relation to this application:</h2>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('authorize_to_agent',['NO','YES, please fill in the question No.9 below'],null,true) }}
                                </div>
                            </div>

                            <div class="row">
                                <h2 class="is-size-4 has-text-grey">9: Details of the Agent</h2>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('agent_name',false) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('contact_person',false) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('telephone',false) }}
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column is-8">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('email',false) }}
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('fax',false) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="field is-grouped">
                                    <div class="control">
                                        <button class="button is-link">Apply Now</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="column is-1"></div>
            </div>
        </div>
    </div>
@endsection