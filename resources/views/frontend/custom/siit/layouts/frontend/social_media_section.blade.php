<section class="section is-paddingless we-social-wrap" style="min-height: 220px;">
    <div class="container">
        <div class="columns is-marginless">
            <div class="column "></div>
            <div class="column ">
                <br>
                <div class="box facebook-btn mt-20">
                    <a href="{{ $siteConfig->facebook }}">
                        <i class="fab fa-facebook-f"></i>&nbsp;FACEBOOK
                    </a>
                </div>
            </div>
            <div class="column ">
                <br>
                <div class="box twitter-btn mt-20">
                    <a href="{{ $siteConfig->facebook }}">
                        <i class="fab fa-twitter"></i>&nbsp;FOLLOW
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
            <div class="column "></div>
        </div>
    </div>
</section>