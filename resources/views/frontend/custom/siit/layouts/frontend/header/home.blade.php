<style>
    .navbar-link::after{
        border-color: grey !important;
    }
</style>
<div id="navigation-app">

    <nav id="navbar" class="navbar">
        <div class="container bg-transparent" id="home-nav-header">
            <div class="navbar-brand is-marginless">
                @if(empty($siteConfig->logo))
                    {{ str_replace('_',' ',env('APP_NAME','Home')) }}
                @else
                    <a id="logo-top" class="" href="{{ url('/') }}">
                        <img alt="SIIT: a bridge across cultures" src="{{ asset($siteConfig->logo) }}" id="" class="image">
                    </a>
                @endif
            </div>

            <div id="navDesktopWrap" class="full-width is-marginless">

                <div class="navbar-menu">
                    <div class="navbar-end sm-nav">
                        <a class="navbar-item" href="{{ url('/') }}" title="{{ trans('general.menu_home') }}">
                            <i class="fas fa-home"></i>&nbsp;{{ trans('general.menu_home') }}
                        </a>
                        @if(empty(session('user_data')))
                            <a class="navbar-item" href="{{ url('/frontend/customers/login') }}" title="{{ trans('general.student_login') }}">
                                <i class="fas fa-sign-in-alt"></i>&nbsp;{{ trans('general.student_login') }}
                            </a>
                        @elseif(!empty(session('user_data.uuid')))
                            <a class="navbar-item" href="{{ url('/frontend/my_profile/'.session('user_data.uuid')) }}" title="{{ trans('general.my_dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>&nbsp;{{ trans('general.my_dashboard') }}
                            </a>
                            <a class="navbar-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="{{ trans('general.menu_logout') }}">
                                <i class="fas fa-sign-out-alt"></i>&nbsp;{{ trans('general.menu_logout') }}
                            </a>
                        @endif
                        <a class="navbar-item" onclick="event.preventDefault();">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </nav>

    @include(_get_frontend_layout_path('frontend.header.maga_menu'))

    <section class="bg-img d-flex" style="background-image: url({{ asset('/images/frontend/h1.png') }});min-height:800px;">
    <div class="container align-self-center" >
        <div class="home-text">
            <h2 class="has-text-centered">A BRIDGE <span class="super-bold">ACROSS</span> CULTURES</h2>
        </div>
    </div>
    </section>
    <div class="is-clearfix"></div>

    @if(false)
    <div class="container header-widget-wrap">
        <div class="columns headline-box" style="margin-top: 200px;margin-bottom: 220px;">

        </div>
        @if(false)
        <div class="columns header-widget">
            @foreach($latestNews as $key=>$pageNews)
                @if(false)
                    <div class="column is-3-desktop is-4-tablet is-12-mobile">
                        <div class="card">
                            <div class="card-image">
                                <figure>
                                    <img src="{{ $pageNews->getFeatureImageUrl() }}" alt="{{ $pageNews->title }}">
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-content">
                                        <p class="title is-4">{{ $pageNews->title }}</p>
                                        <p class="subtitle is-6 mt-20"><i>{{ $pageNews->teasing }}</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
    @endif
    @if(false)
    <div class="container header-events-wrap">
        <div class="content">
            <div class="columns is-marginless">
                @foreach($latestEvents as $key=>$event)
                    @if(false)
                        <div class="column event-box">
                            <div class="card">
                                <div class="card-content">
                                    <div class="content is-paddingless">
                                        <h3 class="event-title">{{ $event->title }}</h3>
                                        <time datetime="2016-1-1">{{ $event->start->format('H:i A - d M Y') }}</time>
                                        <br>
                                        <div class="brief">
                                            {!! $event->teasing !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if(false)
                    <div class="column event-box is-paddingless" style="background-color: black;">
                        <iframe src="https://www.youtube.com/embed/MhMjF2FB2O0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>