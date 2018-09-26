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
<div class="columns">
    <div class="column">
        <el-upload
                class="upload-demo"
                action="{{ route('api.files.student.attachment.upload') }}"
                :on-preview="handlePreview"
                :on-remove="handleRemove"
                :before-remove="beforeRemove"
                :data="{type:'{{ \App\Models\User\Attachment::ENGLISH_CERTIFICATES_AND_TRANSCRIPT }}',uuid:currentStudentUuid}"
                multiple
                :limit="10"
                :on-exceed="handleExceed"
                :file-list="englishProficiencyDocuments">
            <el-button size="small" type="danger">{{ trans('general.Upload_Support_Documents') }}</el-button>
            <div slot="tip" class="el-upload__tip has-text-danger">{{ trans('general.English_Proficiency_Upload_Tip') }}</div>
        </el-upload>
    </div>
</div>