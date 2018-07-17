@if(isset($footer))
    {!! $footer->content !!}
@else
    <div class="footer d-flex justify-content-center">
        <div class="container">
            <div class="columns">
                <div class="column">
                    {!! \App\Models\Utils\AMP\MediaUtil::NormalImage(asset($siteConfig->logo),'SIIT: a bridge across cultures', 254, 117, 'image') !!}
                    <img src="http://apei.edu.au/wp-content/themes/apei/images/f_logo.png" alt="APEI" style="width: 254px; margin-top: 14px;">
                    <div class="p-2 mt-20">
                        <p style="margin-top: -35px;">Australian Professional Education Institute</p>
                    </div>
                </div>
                <nav class="column is-half">
                    <div class="columns">

                        @foreach($rootMenus as $key=>$rootMenu)
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
                        @endforeach
                    </div>
                </nav>
                <div class="column">
                    <label class="label">Sign up for our newsletter</label>
                    <div class="field has-addons">

                        <div class="control">
                            <input class="input" type="text" placeholder="Email Address">
                        </div>
                        <div class="control">
                            <a class="button is-info">
                                Subscribe
                            </a>
                        </div>
                    </div>
                    <br>
                    <label class="label">Follow us</label>
                    <p class="social-icons">
                        <a target="_blank" href="{{ $siteConfig->twitter }}" title="新浪微博"><i class="fab fa-weibo"></i></a>
                        <a target="_blank" href="{{ $siteConfig->facebook }}" title="Facebook"><i class="fab fa-facebook-square"></i></a>
                        <a target="_blank" href="{{ $siteConfig->google_plus }}" title="微信公众号"><i class="fab fa-weixin"></i></a>
                    </p>
                </div>
            </div>
            <div class="columns">
                <div class="column" style="border-top: solid 1px #13213b;">
                    <br>
                    <p class="has-text-centered">
                        Copyright © 2014 Australian Professional Education Institute Pty Ltd trading as Sydney Institute of Interpreting and Translating
                    </p>
                    <p class="has-text-centered">
                        Email: <a class="has-text-danger" href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>,&nbsp;&nbsp;
                        Phone: <span class="has-text-danger">{{ $siteConfig->contact_phone }}</span>&nbsp;&nbsp;
                        ABN: <span class="has-text-danger">30 128 128 503</span>&nbsp;&nbsp;
                        A registered training organization: 91490 and a CRICOS Provider: 03069K
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif