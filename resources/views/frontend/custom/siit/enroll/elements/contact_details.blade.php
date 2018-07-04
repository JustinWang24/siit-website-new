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