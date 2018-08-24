@if(isset($footer))
    {!! $footer->content !!}
@else
    <div class="footer d-flex justify-content-center">
        <div class="container">
            <div class="columns">
                <div class="column">
                    {!! \App\Models\Utils\AMP\MediaUtil::NormalImage(asset($siteConfig->logo_dark),'SIIT: a bridge across cultures', 254, 117, 'image') !!}
                    <img src="{{ asset('images/frontend/custom/new-ape.png') }}" alt="APEI" style="width: 254px; margin-top: 14px;">
                </div>
                <nav class="column is-three-quarters">
                    <div class="columns">

                        {{--@foreach($rootMenus as $key=>$rootMenu)
                            <div class="column">
                                <?php
                                $tag = $rootMenu->html_tag;
                                $children = $rootMenu->getSubMenus();
                                ?>
                                <p style="border-bottom: solid 1px white;line-height: 36px;">
                                <a class="is-size-4" href="{{ $rootMenu->link_to=='/' ? '/' : $rootMenu->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                                    {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                                </a>
                                </p>
                                @if(count($children) > 0)

                                        @foreach($children as $sub)
                                            <p>
                                            <a class="" href="{{ $sub->link_to=='/' ? '/' : $sub->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                                {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                            </a>
                                            </p>
                                        @endforeach

                                @endif
                            </div>
                        @endforeach--}}

                    </div>
                </nav>
            </div>
            <div class="columns">
                <div class="column" style="border-top: solid 1px #13213b;">
                    <br>
                    <p class="has-text-centered">
                        Copyright © 2014 Australian Professional Education Institute Pty Ltd trading as Sydney Institute of Interpreting and Translating
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