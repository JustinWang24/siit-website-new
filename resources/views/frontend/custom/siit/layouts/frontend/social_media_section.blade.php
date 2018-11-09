<section class="section is-paddingless we-social-wrap" style="min-height: 220px;background-repeat: no-repeat;background-size:cover;background-image: url({{ asset('images/frontend/custom/social-bg.jpg') }})">
    <div class="container">
        <div class="columns mt-20">
            <div class="column mt-20">
                <h2 class="is-size-3 has-text-white has-text-centered">{{ trans('general.Join_the_conversations') }}</h2>
                <p class="has-text-centered mt-20">
                    <a href="{{ strpos($siteConfig->facebook,'http') !== false ? $siteConfig->facebook : 'https://'.$siteConfig->facebook }}" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{ strpos($siteConfig->twitter,'http') !== false ? $siteConfig->twitter : 'https://'.$siteConfig->twitter }}" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ asset('images/wechat.jpg') }}" id="single_image" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-weixin"></i>
                    </a>
                    <a href="https://www.weibo.com/siithome?s=6cm7D0" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-weibo"></i>
                    </a>
                    <a href="{{ strpos($siteConfig->instagram,'http') !== false ? $siteConfig->instagram : 'https://'.$siteConfig->instagram }}" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ strpos($siteConfig->google_plus,'http') !== false ? $siteConfig->google_plus : 'https://'.$siteConfig->google_plus }}" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-google-plus"></i>
                    </a>
                    <a href="{{  strpos($siteConfig->linked_in,'http') !== false ? $siteConfig->linked_in : 'https://'.$siteConfig->linked_in }}" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCCNOZblQBg4Ef2To16v5TZg" target="_blank" class="has-text-white is-size-2-desktop is-size-3-mobile mr-20">
                        <i class="fab fa-youtube"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>