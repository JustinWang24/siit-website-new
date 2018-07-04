@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-20 mt-20">
        <div class="content" id="course-enroll-app">
            <div class="columns">
                <div class="column is-1"></div>
                <div class="column">
                    <div class="content pt-40">
                        <div class="page-title-wrap  mt-20 is-paddingless">
                            <h1 class="is-size-1-desktop is-size-1-mobile mt-0">
                                {{ trans('enrolment.Apply_Online') }}: {{ $course->name }}
                            </h1>
                            <h2>
                                <span class="has-text-danger">({{ $course->brand }})</span> -
                                {{ trans('enrolment.Intake_Date') }}: {{ $axcelerateInstance->get('startdate') }}
                            </h2>
                        </div>
                        @if(!session('user_data.uuid'))
                            <hr>
                        <el-form ref="user" :model="user" label-width="100px" class="is-invisible" id="course-enroll-app-form">
                            <div class="columns" v-show="hasAccount">
                                <div class="column">
                                    <el-form-item label="Please Choose" class="full-width">
                                        <el-select v-model="hasAccount" placeholder="{{ trans('enrolment.Please_choose_your_status') }}" class="full-width">
                                            <el-option label="{{ trans('enrolment.I_already_have_an_account') }}" :value="true"></el-option>
                                            <el-option label="{{ trans('enrolment.I_dont_have_account') }}" :value="false"></el-option>
                                        </el-select>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="columns" v-show="hasAccount">
                                <div class="column">
                                    <el-form-item label="{{ trans('enrolment.Your_Email') }}">
                                        <el-input v-model="user.email" placeholder="{{ trans('enrolment.Your_Email') }}"></el-input>
                                    </el-form-item>
                                    <p class="has-text-success has-text-centered" v-if="emailField.infoMsg2.length>0" v-html="emailField.infoMsg2"></p>
                                </div>
                                <div class="column">
                                    <el-form-item label="{{ trans('enrolment.Password') }}">
                                        <el-input v-model="user.password" placeholder="{{ trans('enrolment.Password') }}"></el-input>
                                    </el-form-item>
                                </div>
                                <div class="column">
                                    <el-form-item>
                                        <el-button :loading="isDoingLogin" icon="el-icon-arrow-right" type="primary" @click="onSubmit">
                                            {{ trans('enrolment.Log_Me_In') }}
                                        </el-button>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="columns" v-show="!hasAccount">
                                <div class="column"  v-if="!showVerificationField">
                                    <el-form-item label="{{ trans('enrolment.Your_Name') }}">
                                        <el-input v-model="user.name" placeholder="{{ trans('enrolment.Your_Name') }}"></el-input>
                                    </el-form-item>
                                </div>
                                <div class="column"  v-if="!showVerificationField">
                                    <el-form-item label="{{ trans('enrolment.Your_Email') }}" v-show="!emailField.isEmailVerified">
                                        <el-input v-model="user.email" placeholder="{{ trans('enrolment.Your_Email') }}"></el-input>
                                    </el-form-item>
                                    <p class="has-text-danger has-text-centered" v-if="emailField.errorMsg.length>0">@{{ emailField.errorMsg }}</p>
                                    <p class="has-text-success has-text-centered" v-if="emailField.infoMsg.length>0">@{{ emailField.infoMsg }}</p>
                                </div>
                                <div class="column" v-if="showVerificationField">
                                    <el-form-item label="{{ trans('enrolment.Code') }}">
                                        <el-input v-model="user.verificationCode" placeholder="{{ trans('enrolment.Code_placeholder') }}"></el-input>
                                    </el-form-item>
                                    <p class="has-text-link has-text-centered" v-if="emailField.infoMsg.length>0">@{{ emailField.infoMsg }}</p>
                                    <p class="has-text-danger has-text-centered" v-if="verificationField.errorMsg.length>0">@{{ verificationField.errorMsg }}</p>
                                </div>
                                <div class="column" v-if="showVerificationField">
                                    <el-form-item label="{{ trans('enrolment.CAPTCHA') }}">
                                        <el-input v-model="user.captcha" placeholder="{{ trans('enrolment.CAPTCHA_placeholder') }}"></el-input>
                                    </el-form-item>
                                    <p class="has-text-centered" v-show="!captchaMatched">
                                        <span class="captcha-box">{{ trans('enrolment.CAPTCHA') }}: @{{ captcha }}</span>
                                    </p>
                                </div>
                                <div class="column">
                                    <el-form-item v-if="!showVerificationField">
                                        <el-button :loading="emailField.isVerifyingEmail" icon="el-icon-circle-check" type="success" @click="getVerificationCode">
                                            {{ trans('enrolment.Verify_My_Email') }}
                                        </el-button>
                                    </el-form-item>
                                    <el-form-item v-if="showVerificationField">
                                        <el-button :disabled="!captchaMatched" :loading="verificationField.isVerifyingCode" icon="el-icon-circle-check" type="primary" @click="verifyCode">
                                            {{ trans('enrolment.Verify_My_Code') }}
                                        </el-button>
                                    </el-form-item>
                                </div>
                            </div>
                        </el-form>
                        @endif

                        <form id="catalog-course-enroll-form" action="{{ url('/catalog/course/confirm-book') }}" method="post" enctype="multipart/form-data" class="{{ session('user_data.uuid')?null:'is-invisible' }}">
                            @csrf
                            <input id="current-intake-item" type="hidden" name="enroll[intake_item]" value="{{ $intakeItem->id }}">
                            <input id="current-course-id" type="hidden" name="enroll[course_id]" value="{{ $course->uuid }}">
                            <input id="current-instance-id" type="hidden" name="enroll[instance]" value="{{ $instanceIdAndType }}">
                            <input type="hidden" name="student[user_id]" value="{{ session('user_data.uuid') }}">
                            <input id="current-group-id" type="hidden" name="student[agent_id]" value="{{ isset($dealer)&&$dealer ? $dealer->id : 0  }}">
                            <hr>
                            <?php $transClass = 'slideRight';  $enterClass='slideRight'; $leaveClass='slideLeft'; ?>
                            <transition name="{{ $transClass }}" enter-active-class="{{ $enterClass }}" leave-active-class="{{ $leaveClass }}">
                            <div v-show="step.current==1">
                            @include('frontend.custom.siit.enroll.elements.personal_details')
                            </div>
                            </transition>
                            <transition name="{{ $transClass }}" enter-active-class="{{ $enterClass }}" leave-active-class="{{ $leaveClass }}">
                                <div v-show="step.current==2">
                                @include('frontend.custom.siit.enroll.elements.contact_details')
                                </div>
                            </transition>
                            <transition name="{{ $transClass }}" enter-active-class="{{ $enterClass }}" leave-active-class="{{ $leaveClass }}">
                            <div v-show="step.current==3">
                                @include('frontend.custom.siit.enroll.elements.english_proficiency')
                                @include('frontend.custom.siit.enroll.elements.personal_details_passport')
                                @include('frontend.custom.siit.enroll.elements.exemptions')
                            </div>
                            </transition>

                            <transition name="{{ $transClass }}" enter-active-class="{{ $enterClass }}" leave-active-class="{{ $leaveClass }}">
                            <div v-show="step.current==4">
                            @include('frontend.custom.siit.enroll.elements.agent')
                            </div>
                            </transition>

                            <hr>
                            <div class="columns">
                                <div class="column">
                                    <button :disabled="!prevBtnEnable" class="button is-primary is-large" v-on:click="goPrev($event)"><&nbsp;{{ trans('general.Prev') }}</button>
                                </div>
                                <div class="column">
                                    <button v-show="nextBtnEnable" class="button is-link is-large pull-right" v-on:click="goNext($event)">{{ trans('general.Next') }}&nbsp;></button>
                                    <button v-show="showSubmitButton" class="button is-large is-link pull-right" v-on:click="confirmToEnroll($event)">{{ trans('general.Apply_Now') }}</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <blockquote class="mt-10">{{ trans('enrolment.notes') }}</blockquote>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="column is-1"></div>
            </div>
        </div>
    </div>
@endsection