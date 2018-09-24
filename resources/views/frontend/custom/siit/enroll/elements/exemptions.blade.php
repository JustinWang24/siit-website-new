<div class="row">
    <h2 class="is-size-4 enrol-subtitle">5: {{ trans('enrolment.Exemptions_title') }}</h2>
</div>
<div class="columns">
    <div class="column">
        {{ \App\Models\Utils\FormHelper::getInstance()->simpleSelectField('student','applying_exemptions',['NO','YES'],null,true) }}
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
                :data="{type:'{{ \App\Models\User\Attachment::RECOGNITION_OF_PREVIOUS_LEARNING }}',uuid:currentStudentUuid}"
                multiple
                :limit="10"
                :on-exceed="handleExceed"
                :file-list="previousLearningDocuments">
            <el-button size="small" type="danger">{{ trans('general.Upload_Support_Documents') }}</el-button>
            <div slot="tip" class="el-upload__tip has-text-danger">{{ trans('general.Recognition_Upload_Tip') }}</div>
        </el-upload>
    </div>
</div>