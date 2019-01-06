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
                        <p>
                            <a target="_blank" class="button is-success pull-right" href="https://admin.axcelerate.com.au/management/">Axcelerate</a>
                        </p>
                    </div>
                    <div class="content-title-line">
                        <h3>Log in to Moodle</h3>
                    </div>
                    <div class="content-detail-wrap">
                        <p>
                            <a target="_blank" class="button is-success pull-right" href="https://apei.moodle.com.au/">Moodle</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection