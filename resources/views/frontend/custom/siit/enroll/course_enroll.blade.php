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
                                Apply Online: {{ $course->name }}
                            </h1>
                            <h2><span class="has-text-danger">({{ $course->brand }})</span> - Intake Date: {{ $axcelerateInstance->get('startdate') }}</h2>
                        </div>
                        @if(!session('user_data.uuid'))
                            <hr>
                        <el-form ref="user" :model="user" label-width="100px" class="is-invisible" id="course-enroll-app-form">
                            <div class="columns" v-show="hasAccount">
                                <div class="column">
                                    <el-form-item label="Please Choose" class="full-width">
                                        <el-select v-model="hasAccount" placeholder="Please choose your status" class="full-width">
                                            <el-option label="I already have an account" :value="true"></el-option>
                                            <el-option label="I don't have account" :value="false"></el-option>
                                        </el-select>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="columns" v-show="hasAccount">
                                <div class="column">
                                    <el-form-item label="Your Email">
                                        <el-input v-model="user.email" placeholder="Your Email"></el-input>
                                    </el-form-item>
                                    <p class="has-text-success has-text-centered" v-if="emailField.infoMsg2.length>0" v-html="emailField.infoMsg2"></p>
                                </div>
                                <div class="column">
                                    <el-form-item label="Password">
                                        <el-input v-model="user.password" placeholder="Password"></el-input>
                                    </el-form-item>
                                </div>
                                <div class="column">
                                    <el-form-item>
                                        <el-button :loading="isDoingLogin" icon="el-icon-arrow-right" type="primary" @click="onSubmit">Log Me In</el-button>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="columns" v-show="!hasAccount">
                                <div class="column"  v-if="!showVerificationField">
                                    <el-form-item label="Your Name">
                                        <el-input v-model="user.name" placeholder="Your Name"></el-input>
                                    </el-form-item>
                                </div>
                                <div class="column"  v-if="!showVerificationField">
                                    <el-form-item label="Your Email" v-show="!emailField.isEmailVerified">
                                        <el-input v-model="user.email" placeholder="Your email address"></el-input>
                                    </el-form-item>
                                    <p class="has-text-danger has-text-centered" v-if="emailField.errorMsg.length>0">@{{ emailField.errorMsg }}</p>
                                    <p class="has-text-success has-text-centered" v-if="emailField.infoMsg.length>0">@{{ emailField.infoMsg }}</p>
                                </div>
                                <div class="column" v-if="showVerificationField">
                                    <el-form-item label="Code">
                                        <el-input v-model="user.verificationCode" placeholder="Your verification code"></el-input>
                                    </el-form-item>
                                    <p class="has-text-link has-text-centered" v-if="emailField.infoMsg.length>0">@{{ emailField.infoMsg }}</p>
                                    <p class="has-text-danger has-text-centered" v-if="verificationField.errorMsg.length>0">@{{ verificationField.errorMsg }}</p>
                                </div>
                                <div class="column" v-if="showVerificationField">
                                    <el-form-item label="CAPTCHA">
                                        <el-input v-model="user.captcha" placeholder="Enter code below"></el-input>
                                    </el-form-item>
                                    <p class="has-text-centered" v-show="!captchaMatched">
                                        <span class="captcha-box">CAPTCHA: @{{ captcha }}</span>
                                    </p>
                                </div>
                                <div class="column">
                                    <el-form-item v-if="!showVerificationField">
                                        <el-button :loading="emailField.isVerifyingEmail" icon="el-icon-circle-check" type="success" @click="getVerificationCode">
                                            Verify My Email
                                        </el-button>
                                    </el-form-item>
                                    <el-form-item v-if="showVerificationField">
                                        <el-button :disabled="!captchaMatched" :loading="verificationField.isVerifyingCode" icon="el-icon-circle-check" type="primary" @click="verifyCode">
                                            Verify My Code
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
                                    <button :disabled="!prevBtnEnable" class="button is-primary is-large" v-on:click="goPrev($event)">Prev</button>
                                </div>
                                <div class="column">
                                    <button v-show="nextBtnEnable" class="button is-link is-large pull-right" v-on:click="goNext($event)">Next</button>
                                    <button v-show="showSubmitButton" class="button is-large is-link pull-right" v-on:click="confirmToEnroll($event)">Apply Now</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <blockquote class="mt-10">Note: students are encouraged to contact {{ env('APP_NAME') }} Marketing team for exact timetable and training arrangement.</blockquote>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="column is-1"></div>
            </div>
        </div>
    </div>
@endsection