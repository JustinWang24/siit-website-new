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
                    </div>
                </div>

                <div class="navbar-menu">
                    <div class="navbar-end big-nav">
                        @foreach($rootMenus as $key=>$rootMenu)
                            <div class="navbar-item has-dropdown is-hoverable">
                                <?php
                                $tag = $rootMenu->html_tag;
                                $children = $rootMenu->getSubMenus();
                                if($tag && $tag !== 'a'){
                                    echo '<'.$tag.'>';
                                }
                                ?>
                                <a class="navbar-link has-text-white {{ $rootMenu->css_classes }}" href="{{ $rootMenu->link_to=='/' ? '/' : $rootMenu->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                                    {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                                </a>
                                @if(count($children) > 0)
                                    <div class="navbar-dropdown is-boxed">
                                        @foreach($children as $sub)
                                            <a class="navbar-item" href="{{ $sub->link_to=='/' ? '/' : $sub->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                                {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <?php
                                if($tag && $tag !== 'a'){
                                    echo '</'.$tag.'>';
                                }
                                ?>
                            </div>
                        @endforeach
                        <div class="navbar-item">
                            <a class="has-text-white" href="{{ url('/switch-language/'.(app()->getLocale()=='cn' ? 'en':'cn')) }}" title="{{ trans('general.switch_language') }}">
                                {{ trans('general.switch_language') }} <i class="fas fa-language"></i>
                            </a>
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
        <div class="columns headline-box" style="margin-top: 100px;margin-bottom: 220px;">
            <h2>A BRIDGE <span class="super-bold">ACROSS</span> CULTURES</h2>
        </div>
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
    </div>

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
</div>