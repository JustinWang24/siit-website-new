<div class="row">
    <h2 class="is-size-4 enrol-subtitle">2: {{ trans('enrolment.Contact_Details') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','home_address',true, ($studentProfile ? $studentProfile->home_address : null)) }}
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
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','province_current',true, ($studentProfile ? $studentProfile->province_current : null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','post_code_current',false, ($studentProfile ? $studentProfile->post_code_current : null)) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','country_current',false, ($studentProfile ? $studentProfile->country_current : null)) }}
    </div>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','current_residing',[trans('general.Australia'),trans('general.Offshore')],($studentProfile ? $studentProfile->current_residing : 1),true) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','is_pr',['No','Yes'],($studentProfile ? $studentProfile->is_pr : 0),true) }}
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