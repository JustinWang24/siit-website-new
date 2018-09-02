<div class="row">
    <h2 class="is-size-4 enrol-subtitle">3:{{ trans('enrolment.English_Proficiency') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','form_of_test',['IELTS','TOEFL','CAE','PTE Academic','Other'],null,true) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','form_of_test_other',false) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('english_test_certificate_image',false,trans('enrolment.english_test_certificate_image')) }}
        @if($studentProfile->english_test_certificate_image)
            <p><a target="_blank" href="{{ asset($studentProfile->english_test_certificate_image) }}">{{ trans('enrolment.my_english_test_certificate_image') }}</a></p>
        @endif
    </div>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','test_score') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','test_taken_date',true) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','english_proficiency_certificate') }}
    </div>
</div>