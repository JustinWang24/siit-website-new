@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 user-profile-manager-app" id="user-profile-manager-app">
        <div class="content">
            <div class="columns is-marginless">
                @include(_get_frontend_theme_path('customers.elements.dashboard.left_nav'))

                <div class="column is-three-quarter content-block content-two-third-right">
                    <div class="content-title-line">
                        <h3>{{ trans('general.Address') }}</h3>
                    </div>

                    <div class="content-detail-wrap">
                        <div class="content-line">
                            <label><i class="fas fa-map-signs has-text-danger"></i></label>
                            <label class="value">{{ $user->addressText() }}</label>
                        </div>
                    </div>

                    <div class="content-title-line">
                        <br>
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
                </div>
            </div>
        </div>
    </div>
@endsection