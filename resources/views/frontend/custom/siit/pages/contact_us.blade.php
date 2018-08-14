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
            </div>
        </div>
        <div class="column">
            <div class="box">
                <article class="media">
                    <div class="media-content">
                        <div class="content">
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
                            <p><strong>Sydney Campus: George St</strong></p>
                            <p>George St. campus address: Level 5, 841 George Street, Sydney NSW 2000</p>
                            <p>Postal Address: PO Box K1, Haymarket NSW 1240</p>
                            <p>Email:  <a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>  Tel: +61 02 8090 3266 or 9283 5759 Fax:+61 02 8958 0655</p>
                            <p>Website: <a href="http://www.siit.nsw.edu.au">http://www.siit.nsw.edu.au</a> Weibo: <a href="weibo.com/siithome">weibo.com/siithome</a></p>
                            <p>National 1300 No: 1300 769 588</p>
                            <iframe style="width: 100%;height: 450px;border:0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.2425281774604!2d151.20062825174617!3d-33.88340718055727!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae269619d221%3A0x6bf481f7bfd2762d!2sLevel+5%2F841+George+St%2C+Haymarket+NSW+2000!5e0!3m2!1sen!2sau!4v1534000117019" frameborder="0" allowfullscreen></iframe>
                            <hr>
                            <p><strong>Sydney Campus: Market St</strong></p>
                            <p>Market St. campus address: Level 4, 22 Market Street, Sydney NSW 2000</p>
                            <p>Tel: +61 02 8090 3266 or 02 8319 2940</p>
                                <iframe style="width: 100%;height: 450px;border:0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.738006205027!2d151.2028089517462!3d-33.87064228056081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae3ece2c8bc1%3A0x756901a4192c9b87!2sLevel+4%2F22+Market+St%2C+Sydney+NSW+2000!5e0!3m2!1sen!2sau!4v1534000252879" frameborder="0" allowfullscreen></iframe>
                            <hr>
                            <p><strong>Brisbane Campus:</strong></p>
                            <p>Address: Level 1, 344 Queen St, Brisbane QLD, 4000</p>
                            <p>Postal Address: PO Box 667, Brisbane QLD 4001</p>
                            <p>Email:  <a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>  </p><p>Tel: +61 07 3088 2850 Fax:+61 02 8958 0655 </p><p>TMobile: 0452 618 118 </p><p>TWebsite:
                                <a href="http://www.siit.nsw.edu.au">http://www.siit.nsw.edu.au</a> </p><p>TWeibo: <a href="weibo.com/siithome">weibo.com/siithome</a></p>
                                <iframe style="width: 100%;height: 450px;border:0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.094115541139!2d153.02679985165807!3d-27.46632918280826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b915a1d0ee5a841%3A0x6d4690302f483185!2sUnit+1%2F344+Queen+St%2C+Brisbane+City+QLD+4000!5e0!3m2!1sen!2sau!4v1534000309232" frameborder="0" allowfullscreen></iframe>
                            <hr>
                            <p><strong>Melbourne Campus:</strong></p>
                            <p>Address: Level 4, 341 Queen St, Melbourne VIC, 3000</p>
                            <p>Email: <a href="mailto:melbourne@siit.nsw.edu.au">melbourne@siit.nsw.edu.au</a></p><p> Tel: +61 03 9005 5511 </p><p>Mobile: 0429 292 811 </p><p>Website:
                                <a href="http://www.siit.nsw.edu.au">http://www.siit.nsw.edu.au</a> </p><p>Weibo: <a href="weibo.com/siithome">weibo.com/siithome</a></p>
                                <iframe style="width: 100%;height: 450px;border:0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3152.132245716262!2d144.95594195180817!3d-37.81037127965352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d3582c30917%3A0x6df6ee4e25e0ff0!2sLevel+4%2F341+Queen+St%2C+Melbourne+VIC+3000!5e0!3m2!1sen!2sau!4v1534000432153" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection