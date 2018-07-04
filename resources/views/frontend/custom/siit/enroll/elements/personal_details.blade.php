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
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','disability_required',['NO','YES'],($studentProfile ? $studentProfile->disability_required : 0),true,'Do you have a disability for which additional assistance may be required?') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('disability_required_file',false,'If YES, please attach a separate sheet outlining this disability and assistance required') }}
    </div>
</div>
