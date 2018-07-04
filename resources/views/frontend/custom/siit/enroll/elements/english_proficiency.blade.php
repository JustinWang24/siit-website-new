<div class="row">
    <h2 class="is-size-4 enrol-subtitle">3:English Proficiency</h2>
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