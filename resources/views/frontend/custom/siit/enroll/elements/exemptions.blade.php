<div class="row">
    <h2 class="is-size-4 has-text-grey">5: Would you like to seek exemptions based on your previous qualifications and/or working experience?</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','applying_exemptions',['NO','YES'],null,true,'Are you applying for exemptions??') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleFileField('applying_exemptions_files',false,'If Yes, please complete the application form for exemption with your supporting documents such as unit outline and qualifications before commencement of your desired course(s).',null,true) }}
    </div>
</div>