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
        @if($studentProfile && $studentProfile->english_test_certificate_image)
            <p id="existed-english-test-file-link"><a target="_blank" href="{{ asset('/storage/'.$studentProfile->english_test_certificate_image) }}">{{ trans('enrolment.my_english_test_certificate_image') }}</a></p>
        @endif
    </div>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','test_score',true,($studentProfile ? $studentProfile->test_score:null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','test_taken_date',true,($studentProfile ? $studentProfile->test_taken_date:null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','english_proficiency_certificate',true,($studentProfile ? $studentProfile->english_proficiency_certificate:null)) }}
    </div>
</div>