<div class="row">
    <h2 class="is-size-4 enrol-subtitle">1: {{ trans('enrolment.title_Personal_Detail') }}</h2>
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
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','gender',[2=>trans('enrolment.Unspecified'),1=>trans('general.Male'),0=>trans('general.Female')],($studentProfile ? $studentProfile->gender : 2)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','country_of_citizenship',true,($studentProfile ? $studentProfile->country_of_citizenship : null)) }}
    </div>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','passport',true,($studentProfile ? $studentProfile->passport : null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','visa_category',false,($studentProfile ? $studentProfile->visa_category : null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','USI',false,($studentProfile ? $studentProfile->usi : null)) }}
    </div>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','disability_required',['NO','YES'],($studentProfile ? $studentProfile->disability_required : 0),true,trans('enrolment.disability_input')) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('disability_required_file',false,trans('enrolment.disability_input_attachment')) }}
    </div>
</div>