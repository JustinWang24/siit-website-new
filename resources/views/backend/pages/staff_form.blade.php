@extends('layouts.backend')

@section('content')
    <div id="staff-manager-app" class="invisible">
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
                <el-form-item label="Name" prop="name" required>
                    <el-input placeholder="Required: Full Name" v-model="currentPage.name"></el-input>
                </el-form-item>
                <el-form-item label="Job Title" prop="job_title" required>
                    <el-input placeholder="Required: Student Service Officer, for instance" v-model="currentPage.job_title"></el-input>
                </el-form-item>
                <el-form-item label="Employee Code" prop="staff_badge_code">
                    <el-input placeholder="Optional: Employee code" v-model="currentPage.staff_badge_code"></el-input>
                </el-form-item>
                <el-form-item label="Status" required>
                    <el-select v-model="currentPage.status" placeholder="Please choose">
                        <el-option label="In-service" value="1"></el-option>
                        <el-option label="Departure" value="0"></el-option>
                    </el-select>
                </el-form-item>
                <hr>

                <div class="columns">
                    <div class="column">
                        <?php $types = \App\Models\Staff::GetStaffTypes(); ?>
                        <el-form-item label="Staff Type" required>
                            <el-select v-model="currentPage.type" placeholder="Please choose">
                                @foreach($types as $key=>$type)
                                    <el-option label="{{ $type }}" value="{{ $key }}"></el-option>
                                @endforeach
                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="column">
                        <el-form-item label="Campus" required>
                            <el-select v-model="currentPage.brand_id" placeholder="N.A">
                                <el-option label="NOT AVAILABLE" value="0"></el-option>
                                @foreach($allCampus as $campus)
                                    <el-option label="{{ $campus->name }}" value="{{ $campus->id }}"></el-option>
                                @endforeach
                            </el-select>
                        </el-form-item>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <?php $divisions = \App\Models\Staff::GetDivisions(); ?>
                        <el-form-item label="Division" required>
                            <el-select v-model="currentPage.division" placeholder="N.A">
                                <el-option label="NOT AVAILABLE" value="0"></el-option>
                                @foreach($divisions as $key=>$division)
                                    <el-option label="{{ $division }}" value="{{ $key }}"></el-option>
                                @endforeach
                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="column">
                        <?php $groupNames = \App\Models\Staff::GetJobGroups(); ?>
                        <el-form-item label="Group" required>
                            <el-select v-model="currentPage.job_group" placeholder="N.A">
                                <el-option label="NOT AVAILABLE" value="0"></el-option>
                                @foreach($groupNames as $key=>$groupName)
                                    <el-option label="{{ $groupName }}" value="{{ $key }}"></el-option>
                                @endforeach
                            </el-select>
                        </el-form-item>
                    </div>
                </div>

                <hr>
                <div class="columns">
                    <div class="column"></div>
                    <div class="column"></div>
                </div>

                <div class="columns">
                    <div class="column">
                        <el-form-item label="Email" prop="email" required>
                            <el-input placeholder="Required: Email" v-model="currentPage.email"></el-input>
                        </el-form-item>
                    </div>
                    @if(empty($staff->id))
                    <div class="column">
                        <el-form-item label="Password" prop="password">
                            <el-input placeholder="Optional: If this staff needs to login backend" v-model="currentPage.password"></el-input>
                        </el-form-item>
                    </div>
                    @endif
                </div>

                <div class="columns">
                    <div class="column">
                        <el-form-item label="Phone" prop="phone" required>
                            <el-input placeholder="Required: Phone" v-model="currentPage.phone"></el-input>
                        </el-form-item>
                    </div>
                    <div class="column">
                        <el-form-item label="Fax" prop="fax">
                            <el-input placeholder="Optional: Fax" v-model="currentPage.fax"></el-input>
                        </el-form-item>
                    </div>
                </div>

                <el-form-item label="Avatar">
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
                <el-button type="primary" v-on:click="savePage('currentPage')">
                    <i class="el-icon-upload2"></i>&nbsp; Save
                </el-button>
            </el-form>
        </div>
    </div>
@endsection
