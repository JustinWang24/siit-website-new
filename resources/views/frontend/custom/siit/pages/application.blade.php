@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <section style="position: relative;">
        <div class="container">
            <div class="content page-content-wrap" style="padding: 60px;">
                <div class="columns">
                    <div class="column">
                        <div class="box" style="max-width: 800px; margin: 0 auto;  background-color: #ffffffa8;">
                            <h2 class="is-size-3">{{ trans('general.apply-now') }}</h2>
                            <hr>
                            <form action="{{ url('application-form') }}" method="post" id="apply-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="user" value="{{ session('user_data.uuid') }}">
                                <div class="columns">
                                    <div class="column">
                                         <div class="field">
                                            <label class="label">{{ trans('general.name') }}</label>
                                            <div class="control has-icons-left">
                                                <input class="input" name="apply[name]" type="text" placeholder="{{ trans('general.name') }}" id="input-name" required>
                                                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">{{ trans('general.title') }}</label>
                                            <div class="control has-icons-left">
                                                <select name="apply[title]" id="input-title" required>
                                                    <option value="" disabled="disabled" selected>Your Title</option>
                                                    <option value="Mr.">Mr.</option>
                                                    <option value="Mrs.">Mrs.</option>
                                                    <option value="Miss.">Miss.</option>
                                                    <option value="Dr.">Dr.</option>
                                                    <option value="Ms.">Ms.</option>
                                                    <option value="Prof.">Prof.</option>
                                                </select>
                                                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">{{ trans('general.Phone') }}</label>
                                    <div class="control has-icons-left">
                                        <input class="input" name="apply[mobile]" type="text" placeholder="{{ trans('general.Phone') }} #" id="input-phone" required>
                                        <span class="icon is-small is-left"><i class="fas fa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">{{ trans('general.company') }}</label>
                                    <div class="control has-icons-left">
                                        <input class="input" name="apply[company]" type="text" placeholder="{{ trans('general.company') }}" id="input-company" required>
                                        <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">{{ trans('general.Email') }}</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="email" placeholder="{{ trans('general.Email') }}" name="apply[email]" id="input-email" required>
                                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                    </div>
                                </div>
                                <div class="field is-grouped">
                                    <div class="control">
                                        <button class="button is-link" id="apply-btn">{{ trans('general.register') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection