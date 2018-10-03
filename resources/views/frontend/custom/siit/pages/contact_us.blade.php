@extends(_get_frontend_layout_path('frontend'))
@section('content')

<section style="background-image: linear-gradient(#ffffff,#ccdde7,#9abfd7,#4b92c0);position: relative;">

    <div class="container">
        <div class="content page-content-wrap" style="padding: 60px;">
            <div class="columns" id="contact-us-app">
            <div class="column">
                <div class="box" style="max-width: 800px; margin: 0 auto;  background-color: #ffffffa8;">
                    <h2 class="is-size-3">{{ trans('general.title_contact_us') }}</h2>
                    <hr>
                    <form action="{{ url('contact-us') }}" method="post" id="contact-us-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="user" value="{{ session('user_data.uuid') }}">
                        <div class="field">
                            <label class="label">{{ trans('general.name') }}</label>
                            <div class="control has-icons-left">
                                <input class="input" name="name" type="text" placeholder="{{ trans('general.name') }}" id="input-name" required>
                                <span class="icon is-small is-left">
                                  <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">{{ trans('general.Phone') }}</label>
                            <div class="control has-icons-left">
                                <input class="input" name="mobile" type="text" placeholder="{{ trans('general.Phone') }} #" id="input-phone" required>
                                <span class="icon is-small is-left">
                                  <i class="fas fa-phone"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">{{ trans('general.Email') }}</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="email" placeholder="{{ trans('general.Email') }}" name="email" id="input-email" required>
                                <span class="icon is-small is-left">
                                  <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">{{ trans('general.Message') }}</label>
                            <div class="control">
                                <textarea rows="6" class="textarea" placeholder="{{ trans('general.Say_Something') }} ..." id="input-message" name="message"></textarea>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" checked>
                                    {{ trans('general.I_agree') }} <a href="{{ url('/terms') }}">{{ trans('general.terms') }}</a>
                                </label>
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link" id="submit-contact-us-btn">{{ trans('general.Submit') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="notification is-primary" style="display: none;margin-top: 10px;" id="txt-on-success">
                        Your enquiry form has been saved, we will contact you very soon!
                    </div>
                    <div class="notification is-danger" style="display: none;margin-top: 10px;" id="txt-on-fail">
                        System is busy, please try again later!
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="box" style="margin: 0 auto;  background-color: #ffffffa8;">
                    <div class="ct-box">
                        <h3>Sydney George Street Campus</h3>
                        <ul>
                            <li>Address: Level 5, 841 George Street, Sydney NSW 2000</li>
                            <li>Postal Address: PO Box K1, Haymarket NSW 1240</li>
                            <li>Email: info@siit.nsw.edu.au</li>
                            <li>Tel: +61 02 8090 3266 or 9283 5759</li>
                            <li>Fax:+61 02 8958 0655</li>
                            <li>National 1300 No: 1300 769 588</li>
                        </ul>
                    </div>
                    <div class="ct-box">
                        <h3>Sydney Market Street Campus</h3>
                        <ul>
                            <li>Address: Level 4, 22 Market Street, Sydney NSW 2000</li>
                            <li>Tel: +61 02 8090 3266 or 02 8319 2940</li>
                        </ul>
                    </div>
                    <div class="ct-box">
                        <h3>Melbourne Campus</h3>
                        <ul>
                            <li>Address: Level 4, 341 Queen St, Melbourne VIC, 3000</li>
                            <li>Email: melbourne@siit.nsw.edu.au</li>
                            <li>Tel: +61 03 9005 5511</li>
                            <li>Fax:+61 02 8958 0655</li>
                            <li>Mobile: +61 426235679 | 0426 787 676 | 0413 872 000</li>
                        </ul>
                    </div>
                    <div class="ct-box">
                        <h3>Brisbane Campus</h3>
                        <ul>
                            <li>Address: Level 4, 344 Queen St, Brisbane QLD, 4000</li>
                            <li>Postal Address: PO Box 667, Brisbane QLD 4001</li>
                            <li>Email: info@siit.nsw.edu.au</li>
                            <li>Tel: +61 07 3088 2850</li>
                            <li>Fax:+61 02 8958 0655</li>
                            <li>Mobile: 0452 618 118</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection