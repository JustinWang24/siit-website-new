@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 user-profile-manager-app" id="user-profile-manager-app">
        <div class="content">
            <div class="columns is-marginless">
                @include(_get_frontend_theme_path('customers.elements.dashboard.left_nav'))

                <div class="column is-three-quarter content-block content-two-third-right">
                    <div class="content-title-line">
                        <h3>{{ trans('general.My_Contact_Detail') }}</h3>
                    </div>
                    <div class="content-detail-wrap">
                        <form method="post" action="{{ url('frontend/my_profile') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $user->uuid }}">
                            <div class="field">
                                <label for="staticEmail" class="label">{{ trans('general.Email') }}</label>
                                <div class="control">
                                    <input type="text" readonly class="input" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">{{ trans('general.Name') }}</label>
                                <div class="control">
                                    <input type="text" name="name" class="input"  placeholder="Full name" value="{{ $user->name }}">
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">{{ trans('general.Phone') }}</label>
                                <div class="control">
                                    <input type="text" name="phone" class="input"  placeholder="Phone" value="{{ $user->phone!=='n.a' ? $user->phone : $user->studentProfile->phone_number }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">{{ trans('general.Address') }}</label>
                                <input type="text" name="address" class="input" placeholder="1234 Main St" value="{{ $user->address!=='n.a n.a' ? $user->address : $user->studentProfile->current_address }}">
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">{{ trans('general.City') }}</label>
                                        <input type="text" class="input" value="{{ $user->city }}"  name="city">
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label for="inputZip" class="label">{{ trans('general.Postcode') }}</label>
                                        <input type="text" name="postcode" class="input" placeholder="Postcode" value="{{ $user->postcode!=='n.a' ? $user->postcode : $user->studentProfile->post_code_current }}">
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">{{ trans('general.State') }}</label>
                                    <div class="select">
                                        <select name="state">
                                            @foreach(\App\Models\Utils\OptionTool::States() as $key=>$value)
                                                <option value="{{ $key }}" {{ $key==($user->state!=='n.a' ? $user->state : $user->studentProfile->province_current) ? 'select' : null }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="button is-link is-pulled-right">{{ trans('general.Update_Password') }}</button>
                        </form>
                    </div>

                    <div class="is-clearfix"></div>
                    <hr>
                    <div class="content-title-line">
                        <h3>{{ trans('general.Manage_Password') }}</h3>
                    </div>
                    <div class="content-detail-wrap">
                        <form method="post" action="{{ url('frontend/update_password') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $user->uuid }}">

                            <div class="field">
                                <label class="label">{{ trans('general.New_Password') }}</label>
                                <div class="control">
                                    <input type="password" class="input" name="new_password"  placeholder="{{ trans('general.New_Password') }}" value="">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">{{ trans('general.Confirm_Password') }}</label>
                                <div class="control">
                                    <input type="password" class="input" name="new_password_confirm" placeholder="{{ trans('general.Confirm_Password') }}" value="">
                                </div>
                            </div>

                            <button type="submit" class="button is-link is-pulled-right">{{ trans('general.Update_Password') }}</button>
                        </form>
                    </div>
                    <div class="is-clearfix"></div>
                    <br>
                    <div class="content-title-line">
                        <h3>{{ trans('student.Profile') }}</h3>
                    </div>
                    <div class="content-detail-wrap">
                        @php
                        $arrayToIgnored = ['id','user_id','agent_id','gender','disability_required','created_at','updated_at','siit_student_id','authorize_to_agent','heard_from','visa_category'];
                        $dropDownsFields = ['is_pr','enrolled_at_siit_previously','seeking_credits_transfer','is_english_your_first_language','applying_exemptions','complete_any_secondary_study','hold_certificate_of_english_proficiency'];
                        @endphp

                        <form method="post" action="{{ url('frontend/update_my_profile') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $user->uuid }}">
                            <div>
                                @foreach($studentProfileArray as $fieldName=>$fieldValue)
                                    @if(!in_array($fieldName, $arrayToIgnored) && !in_array($fieldName, $passportFields) && !in_array($fieldName, $certsFields) && !in_array($fieldName, $dropDownsFields))
                                    <div class="column is-6-desktop is-12-mobile"  style="width: 45%;float: left;margin: 1%;">
                                        <div class="field">
                                            <label class="label">{{ trans('student.'.$fieldName) }}</label>
                                            <div class="control">
                                                <input type="text" class="input" name="sp[{{ $fieldName }}]"  value="{{ $fieldValue }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <div>
                                @foreach($dropDownsFields as $fieldName)
                                    <div class="column is-6-desktop is-12-mobile"  style="width: 45%;float: left;margin: 1%;">
                                        <div class="field">
                                            <label class="label">{{ trans('student.'.$fieldName) }}</label>
                                            <div class="control">
                                                <div class="select">
                                                <select name="sp[{{ $fieldName }}]">
                                                    <option value="0" {{ $studentProfileArray[$fieldName] == 0 ? 'selected' : null }}>NO</option>
                                                    <option value="1" {{ $studentProfileArray[$fieldName] == 1 ? 'selected' : null }}>YES</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                @foreach($passportFields as $passportField)
                                    <div class="column is-12">
                                        <div class="field" style="width: 50%;float:left;">
                                            <label class="label">{{ trans('student.'.$passportField) }}</label>
                                            <div class="file">
                                                <label class="file-label">
                                                    <input class="file-input" type="file" name="{{ $passportField }}">
                                                    <span class="file-cta">
                                                      <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                      </span>
                                                      <span class="file-label">
                                                        Choose a file…
                                                      </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div style="width: 50%;float:left;">
                                            @if(!empty($studentProfileArray[$passportField]))
                                                <img src="{{ asset('storage/'.$studentProfileArray[$passportField]) }}" style="width: 200px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="is-clearfix"></div>
                                @endforeach

                                    @foreach($certsFields as $certsField)
                                        <div class="column is-12">
                                            <div class="field" style="width: 50%;float:left;">
                                                <label class="label">{{ trans('student.'.$certsField) }}</label>
                                                <div class="file">
                                                    <label class="file-label">
                                                        <input class="file-input" type="file" name="{{ $certsField }}">
                                                        <span class="file-cta">
                                                      <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                      </span>
                                                      <span class="file-label">
                                                        Choose a file…
                                                      </span>
                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="field" style="width: 50%;float:left;">
                                                @if(!empty($studentProfileArray[$certsField]))
                                                <a href="{{ asset('storage/'.$studentProfileArray[$certsField]) }}" target="_blank">Uploaded File</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="is-clearfix"></div>
                                    @endforeach
                            </div>
                            <button type="submit" class="button is-link is-pulled-right">{{ trans('general.Submit') }}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection