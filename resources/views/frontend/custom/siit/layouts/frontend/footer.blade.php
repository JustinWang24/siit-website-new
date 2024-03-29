@if(isset($footer))
    {!! $footer->content !!}
@else
    <div class="footer d-flex justify-content-center">
        <div class="container">
            <div class="columns">
                <div class="column">
                    {!! \App\Models\Utils\AMP\MediaUtil::NormalImage(asset($siteConfig->logo_dark),'SIIT: a bridge across cultures', 200, 117, 'image') !!}
                </div>
                <nav class="column is-four-fifths">
                    <div class="columns">
                        <div class="column">
                            <p style="border-bottom: solid 1px white;line-height: 36px;">
                                <a class="is-size-4" href="#" title="{{ trans('general.Quick_links') }}">
                                    {{ trans('general.Quick_links') }}
                                </a>
                            </p>
                            <p>
                                <a href="{{ url('/page/school-calendar') }}" title="{{ trans('general.Important_Dates') }}">
                                    {{ trans('general.Important_Dates') }}
                                </a>
                            </p>
                            <p>
                                <a href="{{ url('/page/blog') }}" title="{{ trans('general.News_Events') }}">
                                    {{ trans('general.News_Events') }}
                                </a>
                            </p>
                            <p>
                                <a href="https://apei.moodle.com.au/" title="{{ trans('general.Study_online') }}">
                                    {{ trans('general.Study_online') }}
                                </a>
                            </p>
                        </div>
                        <div class="column">
                            <p style="border-bottom: solid 1px white;line-height: 36px;">
                                <a class="is-size-4" href="#" title="">
                                    &nbsp;
                                </a>
                            </p>
                            <p>
                                <a href="{{ url('/page/jobs') }}" title="{{ trans('general.Jobs') }}">
                                    {{ trans('general.Jobs') }}
                                </a>
                            </p>
                            <p>
                                <a href="{{ url('/page/internship') }}" title="{{ trans('general.Jobs') }}">
                                    {{ trans('general.Recruit_a_Student') }}
                                </a>
                            </p>
                            <p>
                                <a href="https://www.livingin-australia.com/" title="{{ trans('general.Jobs') }}" target="_blank">
                                    {{ trans('general.Live_in_Australia') }}
                                </a>
                            </p>
                        </div>
                        <div class="column">
                            <p style="border-bottom: solid 1px white;line-height: 36px;">
                                <a class="is-size-4" href="#" title="">
                                    &nbsp;
                                </a>
                            </p>
                            <p>
                                <a href="{{ route('contact_us') }}" title="{{ trans('general.Jobs') }}">
                                    {{ trans('general.Enquiries') }}
                                </a>
                            </p>
                            <p>
                                <a href="{{ url('/page/campus-map') }}" title="{{ trans('general.Jobs') }}" target="_blank">
                                    {{ trans('general.Campus_map') }}
                                </a>
                            </p>
                            <p>
                                <a href="{{ url('group/login') }}" title="{{ trans('general.agent_portal') }}" target="_blank">
                                    {{ trans('general.agent_portal') }}
                                </a>
                            </p>
                        </div>
                        <div class="column footer-logo">
                            <p style="border-bottom: solid 1px white;line-height: 36px;">
                                <a class="is-size-4" href="#" title="{{ trans('general.Partnerships') }}">
                                    {{ trans('general.Partnerships') }}
                                </a>
                            </p>
                            <div style="justify-content: space-around;">
                                <div class="flex-item">
                                    <a href="http://pollardenglish.com/" title="Pollard English" target="_blank">
                                        <img src="{{ asset('images/frontend/custom/poll.png') }}" alt="Pollard English">
                                    </a>
                                </div>
                                <div class="flex-item">
                                    <a href="http://chcservices.edu.au/" title="CHC Services" target="_blank">
                                        <img src="{{ asset('images/frontend/custom/chc.png') }}" alt="CHC Services">
                                    </a>
                                </div>
                                <div class="flex-item">
                                    <a href="http://tiis.edu.au/" title="TIIS" target="_blank">
                                        <img src="{{ asset('images/frontend/custom/tiis.png') }}" alt="TIIS">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="columns">
                <div class="column" style="border-top: solid 1px #13213b;">
                    <br>
                    <p class="has-text-centered">
                        Copyright © 2018 Australian Professional Education Institute Pty Ltd trading as Sydney Institute of Interpreting and Translating
                    </p>
                    <p class="has-text-centered">
                        {{ trans('general.Email') }}: <a class="has-text-danger" href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>,&nbsp;&nbsp;
                        {{ trans('general.Phone') }}: <span class="has-text-danger">{{ $siteConfig->contact_phone }}</span>&nbsp;&nbsp;
                        ABN: <span class="has-text-danger">30 128 128 503</span>&nbsp;&nbsp;
                        A registered training organization: 91490 and a CRICOS Provider: 03069K
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif