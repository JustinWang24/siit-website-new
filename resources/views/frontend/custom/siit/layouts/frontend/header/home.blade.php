<div id="navigation-app">
<div class="header-bg-bar">

</div>
    <nav id="navbar" class="navbar is-spaced">
        <div class="container bg-transparent" id="home-nav-header">
            <div class="navbar-brand is-marginless">
                @if(empty($siteConfig->logo))
                    {{ str_replace('_',' ',env('APP_NAME','Home')) }}
                @else
                    <a id="logo-top" class="" href="{{ url('/') }}">
                        {!! \App\Models\Utils\AMP\MediaUtil::NormalImage(asset($siteConfig->logo),'SIIT: a bridge across cultures', 254, 117, 'image') !!}
                    </a>
                @endif
            </div>
            <div id="navDesktopWrap" class="full-width is-marginless">
                <div class="navbar-menu">
                    <div class="navbar-end sm-nav">
                        <a class="navbar-item" href="">
                            Home
                        </a>
                        <a class="navbar-item" href="">
                            About Us
                        </a>
                        <a class="navbar-item" href="">
                            Student Login
                        </a>
                    </div>
                </div>

                <div class="navbar-menu">
                    <div class="navbar-end big-nav">
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-white" href="#">
                                SIIT News
                            </a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item" href="#">
                                    Sub Menu 1
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 2
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 3
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 4
                                </a>
                                <hr class="navbar-divider">
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-white" href="#">
                                Courses
                            </a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item" href="#">
                                    Sub Menu 1
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 2
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 3
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 4
                                </a>
                                <hr class="navbar-divider">
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-white" href="#">
                                Campus
                            </a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item" href="#">
                                    Sub Menu 1
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 2
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 3
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 4
                                </a>
                                <hr class="navbar-divider">
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-white" href="#">
                                Admission
                            </a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item" href="#">
                                    Sub Menu 1
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 2
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 3
                                </a><a class="navbar-item" href="#">
                                    Sub Menu 4
                                </a>
                                <hr class="navbar-divider">
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                                <a class="navbar-item" href="#">
                                    Sub Menu 5
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="search-form-wrap">
                    <div id="search-btn">
                        <p><i class="fas fa-search"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="is-clearfix"></div>
    <div class="container header-widget-wrap">
        <div class="columns is-marginless headline-box">
            <h2>A BRIDGE <span class="super-bold">ACROSS</span> CULTURES</h2>
        </div>
        <div class="columns header-widget">
            @foreach(range(1,3) as $key)
                <div class="column is-3-desktop is-4-tablet is-12-mobile">
                    <div class="card">
                        <div class="card-image">
                            <figure>
                                <img src="{{ asset('images/frontend/custom/widget/campus'.$key.'.jpg') }}" alt="Placeholder image">
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="media">
                                <div class="media-content">
                                    <p class="title is-4">SIIT news title {{ $key }}</p>
                                    <p class="subtitle is-6 mt-20"><i>Subtitle {{ $key }}</i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container header-events-wrap">
        <div class="content">
            <div class="columns is-marginless">
                @foreach(range(1,3) as $key)
                <div class="column event-box">
                    <div class="card">
                        <div class="card-content">
                            <div class="content is-paddingless">
                                <h3 class="event-title">Event {{ $key }}</h3>
                                <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                                <br>
                                <div class="brief">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.<a href="#">@siit_twitter</a>.
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="column event-box is-paddingless" style="background-color: black;">
                    <iframe src="https://www.youtube.com/embed/MhMjF2FB2O0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>