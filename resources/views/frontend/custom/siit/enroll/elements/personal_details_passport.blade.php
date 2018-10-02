<div class="row">
    <h2 class="is-size-4 enrol-subtitle">4: {{ trans('enrolment.Personal_Details_passport') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','course_1') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','institute_1') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_commenced') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_completed') }}
    </div>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','course_2') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','institute_2') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_commenced_2') }}
    </div>
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','date_completed_2') }}
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
                :data="{type:'{{ \App\Models\User\Attachment::EDUCATION_AND_ACADEMIC_ACHIEVEMENT }}',uuid:currentStudentUuid}"
                multiple
                :limit="10"
                :on-exceed="handleExceed"
                :on-success="handleSuccess"
                :file-list="educationDocuments">
            <el-button size="small" type="danger">{{ trans('general.Upload_Support_Documents') }}</el-button>
            <div slot="tip" class="el-upload__tip has-text-danger">{{ trans('general.Education_Upload_Tip') }}</div>
        </el-upload>
    </div>
</div>