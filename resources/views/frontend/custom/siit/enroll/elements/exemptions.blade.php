<div class="row">
    <h2 class="is-size-4 enrol-subtitle">5: {{ trans('enrolment.Exemptions_title') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','applying_exemptions',['NO','YES'],null,true) }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('applying_exemptions_files',false,trans('enrolment.applying_exemptions_files'),null,true) }}
    </div>
</div>