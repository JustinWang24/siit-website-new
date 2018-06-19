@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 user-profile-manager-app" id="user-profile-manager-app">
        <div class="content">
            <div class="columns is-marginless">
                @include(_get_frontend_theme_path('customers.elements.dashboard.left_nav'))

                <div class="column is-three-quarter content-block content-two-third-right">
                    <div class="content-title-line">
                        <h3>Log in to Axcelerate</h3>
                    </div>
                    <div class="content-detail-wrap">
                        <form method="post" action="{{ url('frontend/change-axuser-password') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $user->uuid }}">
                            <div class="columns">
                                <div class="column">
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','username',true,null) }}
                                </div>
                                <div class="column">
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','old_password',true,null) }}
                                </div>
                                <div class="column">
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','new_password',true,null) }}
                                </div>
                                <div class="column">
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                </div>
                                <div class="column">
                                    {{ \App\Models\Utils\FormHelper::getInstance()->simpleTextField('student','verify_password',true,null) }}
                                </div>
                                <div class="column">
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                </div>
                                <div class="column">
                                    <button type="submit" class="button is-link">Submit</button>
                                    <a target="_blank" class="button is-success pull-right" href="https://admin.axcelerate.com.au/management/">Go to Axcelerate Portal</a>
                                </div>
                                <div class="column">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection