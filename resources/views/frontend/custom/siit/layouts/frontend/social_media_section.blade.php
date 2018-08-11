<section class="section is-paddingless we-social-wrap" style="min-height: 220px;background-repeat: no-repeat;background-size:cover;background-image: url({{ asset('images/frontend/custom/social-bg.jpg') }})">
    <div class="container">
        <div class="columns is-marginless">
            <div class="column ">
                <br>
                <div class="box facebook-btn mt-20">
                    <a href="{{ $siteConfig->facebook }}">
                        <i class="fab fa-facebook-f"></i>&nbsp;{{ trans('general.Facebook') }}
                    </a>
                </div>
            </div>
            <div class="column ">
                <br>
                <div class="box twitter-btn mt-20">
                    <a href="{{ $siteConfig->facebook }}">
                        <i class="fab fa-twitter"></i>&nbsp;{{ trans('general.Twitter') }}
                    </a>
                </div>
            </div>
            <div class="column ">
                <br>
                <div class="box twitter-btn mt-20" style="background-color: #44b549;">
                    <a href="#">
                        <i class="fab fa-weixin"></i>&nbsp;{{ trans('general.WeChat') }}
                    </a>
                </div>
            </div>
            <div class="column ">
                <br>
                <div class="box twitter-btn mt-20" style="background-color: #ff9933;">
                    <a href="https://www.weibo.com/siithome?s=6cm7D0">
                        <i style="color: #e6162d;" class="fab fa-weibo"></i>&nbsp;<span style="color: black;">{{ trans('general.Weibo') }}</span>
                    </a>
                </div>
            </div>
            @if($siteConfig->instagram)
                <div class="column ">
                    <br>
                    <div class="box facebook-btn mt-20">
                        <a href="{{ $siteConfig->instagram }}">
                            <i class="fab fa-instagram"></i>&nbsp;FOLLOW
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>