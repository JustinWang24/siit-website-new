@extends(_get_frontend_layout_path('catalog'))

@section('content')
    <div class="container mt-20 mb-20">
    <div class="content">
        <br>
        <br>
        <br>
        <div class="columns">
            <div class="column is-3"></div>
            <div class="column">
                <div class="box content">
                    <div class="content-title-line">
                        <h3>{{ trans('general.Reset_password') }}</h3>
                    </div>
                    <div class="content-detail-wrap">
                        @if (session('status'))
                            <div class="notification is-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="field">
                                <label for="staticEmail" class="label">{{ trans('general.Email') }}</label>
                                <div class="control">
                                    <input type="text" class="input" id="staticEmail" name="email" value="{{ old('email') }}" placeholder="email@example.com">
                                </div>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <p><a class="is-danger" href="{{ url('frontend/customers/login') }}">{{ trans('general.student_login') }}</a></p>
                                </div>
                                <div class="column">
                                    <button type="submit" class="button is-link is-pulled-right">{{ trans('general.Send_Password_Reset_Link') }}</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="column is-3"></div>
        </div>
        <br>
        <br>
        <br>
    </div>
    </div>
@endsection
