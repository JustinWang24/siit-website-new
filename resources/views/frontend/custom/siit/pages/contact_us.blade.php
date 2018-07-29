@extends(_get_frontend_layout_path('frontend'))
@section('content')
<div class="container mt-10 mb-20">
    <div class="content pl-20 pr-20 page-content-wrap">
    <br>
    <h1 class="is-size-1 has-text-centered is-uppercase">{{ trans('general.menu_contact') }}</h1>
    <br>
    <div class="columns" id="contact-us-app">
        <div class="column">
            <div class="box">
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
                @if($config->embed_map_code)
                    <hr>
                    {!! $config->embed_map_code !!}
                @endif
            </div>
        </div>
        <div class="column">
            <div class="box">
                <article class="media">
                    <div class="media-content">
                        <div class="content">
                            <h1>{{ trans('general.menu_contact') }}</h1>
                            <?php
//                            $fields = $config->getFillableArray();
                            $fields=[];
                            ?>
                            @foreach($fields as $field)
                                @if(!empty($config->$field) && $config->isContactUsField($field))
                                    <p class="pl-10">
                                        {{ ucwords(str_replace('_',' ',$field)) }}:
                                        <strong>{{ $config->$field }}</strong>
                                        <br>
                                    </p>
                                @endif
                            @endforeach
                            <hr>
                            <p><strong>Sydney Campus: George St</strong></p>
                            <p>George St. campus address: Level 5, 841 George Street, Sydney NSW 2000</p>
                            <p>Postal Address: PO Box K1, Haymarket NSW 1240</p>
                            <p>Email:  <a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>  Tel: +61 02 8090 3266 or 9283 5759 Fax:+61 02 8958 0655</p>
                            <p>Website: <a href="http://www.siit.nsw.edu.au">http://www.siit.nsw.edu.au</a> Weibo: <a href="weibo.com/siithome">weibo.com/siithome</a></p>
                            <p>National 1300 No: 1300 769 588</p>
                            <hr>
                            <p><strong>Sydney Campus: Market St</strong></p>
                            <p>Market St. campus address: Level 4, 22 Market Street, Sydney NSW 2000</p>
                            <p>Tel: +61 02 8090 3266 or 02 8319 2940</p>

                            <hr>
                            <p><strong>Brisbane Campus:</strong></p>
                            <p>Address: Level 1, 344 Queen St, Brisbane QLD, 4000</p>
                            <p>Postal Address: PO Box 667, Brisbane QLD 4001</p>
                            <p>Email:  <a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>  </p><p>Tel: +61 07 3088 2850 Fax:+61 02 8958 0655 </p><p>TMobile: 0452 618 118 </p><p>TWebsite:
                                <a href="http://www.siit.nsw.edu.au">http://www.siit.nsw.edu.au</a> </p><p>TWeibo: <a href="weibo.com/siithome">weibo.com/siithome</a></p>

                            <hr>
                            <p><strong>Melbourne Campus:</strong></p>
                            <p>Address: Level 4, 341 Queen St, Melbourne VIC, 3000</p>
                            <p>Email: <a href="mailto:melbourne@siit.nsw.edu.au">melbourne@siit.nsw.edu.au</a></p><p> Tel: +61 03 9005 5511 </p><p>Mobile: 0429 292 811 </p><p>Website:
                                <a href="http://www.siit.nsw.edu.au">http://www.siit.nsw.edu.au</a> </p><p>Weibo: <a href="weibo.com/siithome">weibo.com/siithome</a></p>


                            @if(isset($leads) && count($leads)>0)
                                <h2>Testimonials</h2>
                                <hr>
                                <div class="testimonials-list">
                                    @foreach($leads as $lead)
                                        <p>
                                            <span class="has-text-link">{{ $lead->name }}:</span> {{ $lead->message }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection