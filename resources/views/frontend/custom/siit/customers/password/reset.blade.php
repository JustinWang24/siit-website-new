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
                            <form method="POST" action="{{ route('password.request') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="field">
                                    <label for="email" class="label">{{ trans('general.Email') }}</label>
                                    <div class="control">
                                        <input id="email" type="email" class="input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="field">
                                    <label for="password" class="label">{{ trans('general.New_Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="field">
                                    <label for="password-confirm" class="label">{{ trans('general.Confirm_password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <button type="submit" class="button is-link is-pulled-right">
                                            {{ trans('general.Reset_password') }}
                                        </button>
                                    </div>
                                </div>
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
