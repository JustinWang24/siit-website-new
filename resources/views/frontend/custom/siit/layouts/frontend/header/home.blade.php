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
    <section style="background-color: #f6f6f6;    box-shadow: 0px 1px 10px #94949457;">
        <div class="container">
            <div class="navbar-menu">
                <div class="navbar-end">
                {{--  --}}
                @foreach($rootMenus as $key=>$rootMenu)
                    <div class="navbar-item has-dropdown is-hoverable">
                        <?php
                        $tag = $rootMenu->html_tag;
                        $children = $rootMenu->getSubMenus();
                        if($tag && $tag !== 'a'){
                            echo '<'.$tag.'>';
                        }
                        ?>
                        <a class="navbar-link {{ $rootMenu->css_classes }}" href="{{ $rootMenu->link_to=='/' ? '/' : $rootMenu->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                            {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                        </a>
                        @if(count($children) > 0)
                            <div class="navbar-dropdown is-boxed">
                                @foreach($children as $sub)
                                    @php
                                        $menuUrl = $sub->getMenuUrl();
                                        $pathwaySubmenu = strpos($menuUrl,'University-Pathway-Collection') !== false;
                                    @endphp
                                    @if($pathwaySubmenu)
                                        {{-- 对pathway的特殊处理 --}}
                                        <div class="aside">
                                            <ul class="menu-list">
                                                <li>
                                                    <a class="navbar-item has-low-level-menus" data-content="#pathway-list-subs" href="#" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                                        <i class="fas fa-plus has-text-grey" style="margin-left: 0;"></i>
                                                        <i class="fas fa-minus has-text-grey" style="margin-left: 0;display: none;"></i>
                                                        {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                                    </a>
                                                    <ul id="pathway-list-subs" class="hidden" style="margin-top: 0;">
                                                        @foreach($pathways as $product)
                                                            <li>
                                                                <a href="{{ url('catalog/product/'.$product->uri) }}">
                                                                    {{ $product->getName() }} - {{ trans('general.'.$product->brand).(app()->getLocale()=='cn'?null:trans('general.Campus')) }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <a class="navbar-item" href="{{ $sub->link_to=='/' ? '/' : $sub->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                            {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                        </a>
                                    @endif
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

                @foreach($categoryTags as $key=>$categoryTag)
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link" href="#" title="{{ app()->getLocale()=='cn' && !empty($categoryTag->name_cn) ? $categoryTag->name_cn : $categoryTag->name }}">
                            {{ app()->getLocale()=='cn' && !empty($categoryTag->name_cn) ? $categoryTag->name_cn : $categoryTag->name }}
                        </a>
                        @if(count($categoryTag->children) > 0)
                            <div class="navbar-dropdown is-boxed">
                                @foreach($categoryTag->children as $subCategory)
                                    @php
                                        /** @var \App\Models\Catalog\Category $subCategory */
                                        $courses = $subCategory->productCategories();
                                        $randomString = str_random(10);
                                    @endphp
                                    @if($courses)
                                        <div class="aside">
                                            <ul class="menu-list">
                                                <li>
                                                    <a class="navbar-item has-low-level-menus" data-content="#pathway-list-subs{{ $randomString }}" href="#" title="{{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}">
                                                        <i class="fas fa-plus has-text-grey" style="margin-left: 0;"></i>
                                                        <i class="fas fa-minus has-text-grey" style="margin-left: 0;display: none;"></i>
                                                        {{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}
                                                    </a>
                                                    <ul id="pathway-list-subs{{ $randomString}}" class="mt-0 hidden">
                                                        @foreach($courses as $course)
                                                            <li>
                                                                <a href="{{ url('catalog/product/'.$course->uri) }}">
                                                                    {{ trans('general.'.$course->brand).(app()->getLocale()=='cn'?null:trans('general.Campus')) }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <a class="navbar-item" href="#" title="{{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}">
                                            {{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="navbar-item">
                    <a class="has-text-deep-blue" href="{{ url('/switch-language/'.(app()->getLocale()=='cn' ? 'en':'cn')) }}" title="{{ trans('general.switch_language') }}">
                        {{ trans('general.switch_language') }}
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>
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