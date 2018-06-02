@extends('layouts.backend')

@section('content')
    <div id="pages-manager-app" class="invisible">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    {{ isset($actionName) ? trans('admin.'.$actionName.'.'.$menuName) : trans('admin.new.'.$menuName) }}
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/'.$menuName.'/index') }}"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
            </div>
        </div>

        <div class="container">
            <el-form ref="currentPage" status-icon :rules="rules" :model="currentPage" label-width="160px">
                <el-form-item label="Title" prop="title" required>
                    <el-input placeholder="Required: Event title" v-model="currentPage.title"></el-input>
                </el-form-item>
                <el-form-item label="中文Title" prop="title_cn">
                    <el-input placeholder="中文名称: 必填" v-model="currentPage.title_cn"></el-input>
                </el-form-item>
                <el-form-item label="URI" prop="uri" required>
                    <el-input placeholder="Required: event's URI" v-model="currentPage.uri"></el-input>
                </el-form-item>
                <hr>
                <el-form-item label="Event Type">
                    <el-select v-model="currentPage.type" placeholder="Event Type">
                        <el-option label="Public Event" value="{{ \App\Models\Blog\Event::PUBLIC_EVENT }}"></el-option>
                        <el-option label="Private Event" value="{{ \App\Models\Blog\Event::PRIVATE_EVENT }}"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Location" prop="location" required>
                    <el-input placeholder="Required: Where the event will be hold" v-model="currentPage.location"></el-input>
                </el-form-item>
                <el-form-item label="Attendees" prop="attendees_limit" required>
                    <el-input placeholder="Required: Max number of attendees" v-model="currentPage.attendees_limit"></el-input>
                </el-form-item>
                <el-form-item label="Start at" prop="start" required>
                    <el-date-picker
                            v-model="currentPage.start"
                            type="datetime"
                            format="dd-MM-yyyy HH:mm"
                            placeholder="Required: When the event will start">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="End at" prop="end" required>
                    <el-date-picker
                            v-model="currentPage.end"
                            format="dd-MM-yyyy HH:mm"
                            type="datetime"
                            placeholder="Required: When the event will be end">
                    </el-date-picker>
                </el-form-item>

                <el-form-item label="Feature Image">
                    <el-upload
                            class="avatar-uploader"
                            action="{{ url('/api/images/upload') }}"
                            :multiple="false"
                            :show-file-list="false"
                            :on-success="handleFeatureImageSuccess"
                            :before-upload="beforeImageUpload">
                        <img v-if="currentPage.feature_image" :src="currentPage.feature_image" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <hr>

                <el-form-item label="SEO Keywords">
                    <el-input type="textarea" placeholder="Optional" v-model="currentPage.seo_keyword"></el-input>
                </el-form-item>

                <el-form-item label="SEO Description">
                    <el-input type="textarea" placeholder="Optional" v-model="currentPage.seo_description"></el-input>
                </el-form-item>

                <hr>
                <el-form-item label="Summary" prop="teasing" required>
                    <el-input type="textarea" placeholder="Required: Event's theme, dress code and so on ..." v-model="currentPage.teasing"></el-input>
                </el-form-item>

                <el-form-item label="Content">
                    <vuejs-editor
                            ref="pageContentEditor"
                            class="rich-text-editor"
                            placeholder="Put content here"
                            text-area-id="page-content-editor"
                            image-upload-url="/api/images/upload"
                            existed-images="/api/images/load-all"
                            :original-content="currentPage.content"
                            short-codes-load-url="/api/widgets/load-short-codes"
                    ></vuejs-editor>
                </el-form-item>
                <el-button type="primary" :loading="savingPage" v-on:click="savePage('currentPage')">
                    <i class="el-icon-upload2"></i>&nbsp; Save
                </el-button>
            </el-form>
        </div>
    </div>
@endsection
