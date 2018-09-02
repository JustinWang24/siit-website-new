<div class="box content">
    <div class="content-title-line">
        <h3>{{ trans('general.I_Already_Have_an_Account') }}</h3>
    </div>
    <div class="content-detail-wrap">
        <form method="post" action="{{ url('/frontend/customers/login') }}">
            {{ csrf_field() }}
            <input type="hidden" name="the_referer" value="{{ $the_referer }}">
            <div class="field">
                <label for="staticEmail" class="label">{{ trans('general.Email') }}</label>
                <div class="control">
                    <input type="text" class="input" id="staticEmail" name="email" placeholder="email@example.com">
                </div>
                @if ($errors->has('email'))
                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="field">
                <label for="inputPassword" class="label">{{ trans('general.Password') }}</label>
                <div class="control">
                    <input type="password" class="input" id="inputPassword" name="password" placeholder="Password">
                </div>
                @if ($errors->has('password'))
                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="columns">
                <div class="column">
                    <p><a class="is-danger" href="{{ url('frontend/customers/forget-password') }}">{{ trans('general.Forget_password') }}</a></p>
                </div>
                <div class="column">
                    <button type="submit" class="button is-link is-pulled-right">{{ trans('general.Log_Me_In') }}</button>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>