@extends('layouts.backend')

@section('content')
    <div id="intake-manager-app" class="invisible">
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
                <div class="columns">
                    <div class="column">
                        <?php $types = \App\Models\Catalog\InTake::GetAllTypes(); ?>
                        <el-form-item label="Type" required>
                            <el-select v-model="currentPage.type" placeholder="Please choose">
                                @foreach($types as $key=>$type)
                                    <el-option label="{{ $type }}" value="{{ $key }}"></el-option>
                                @endforeach
                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="column">
                        <el-form-item label="Course" required>
                            <el-select v-model="currentPage.course_id" placeholder="Please choose">
                                <el-option label="NOT AVAILABLE" value="0"></el-option>
                                @foreach($courses as $course)
                                    <el-option label="{{ $course->name }}" value="{{ $course->id }}"></el-option>
                                @endforeach
                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="column">
                        <el-form-item label="Schedule Date" prop="scheduled" required>
                            <el-date-picker
                                    v-model="currentPage.scheduled"
                                    type="date"
                                    placeholder="Required: Schedule Date">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                </div>

                <el-form-item label="Seats" prop="seats" required>
                    <el-input placeholder="Required: Max. seats" v-model="currentPage.seats"></el-input>
                </el-form-item>

                <el-form-item label="Title">
                    <el-input placeholder="Optional: Title, it will use course name as default" v-model="currentPage.title"></el-input>
                </el-form-item>
                <el-form-item label="Code">
                    <el-input placeholder="Optional: Employee code" v-model="currentPage.code"></el-input>
                </el-form-item>

                <div class="columns">
                    <div class="column">
                        <el-form-item label="Online Date" prop="online_date" required>
                            <el-date-picker
                                    v-model="currentPage.online_date"
                                    type="date"
                                    placeholder="Required: Online Date">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                    <div class="column">
                        <el-form-item label="Offline Date">
                            <el-date-picker
                                    v-model="currentPage.offline_date"
                                    type="date"
                                    placeholder="Optional: Offline Date">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                </div>

                <el-form-item label="Description">
                    <vuejs-editor
                            ref="pageContentEditor"
                            class="rich-text-editor"
                            placeholder="Put content here"
                            text-area-id="page-content-editor"
                            :original-content="currentPage.description"
                    ></vuejs-editor>
                </el-form-item>
                <el-form-item label="Description(CN)">
                    <vuejs-editor
                            ref="pageCnContentEditor"
                            class="rich-text-editor"
                            placeholder="Put content in Chinese here"
                            text-area-id="page-cn-content-editor"
                            :original-content="currentPage.description_cn"
                    ></vuejs-editor>
                </el-form-item>
                <el-button type="primary" v-on:click="savePage('currentPage')">
                    <i class="el-icon-upload2"></i>&nbsp; Save
                </el-button>
            </el-form>
        </div>
    </div>
@endsection
