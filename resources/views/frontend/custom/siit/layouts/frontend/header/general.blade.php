<div id="navigation-app">
    <div class="header-bg-bar">

    </div>
    <nav id="navbar" class="navbar is-spaced">
        <div class="container bg-transparent" id="home-nav-header-general">
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
                        <a class="navbar-item" href="{{ url('/') }}" title="Home page">
                            Home
                        </a>
                        <a class="navbar-item" href="" title="Student Login">
                            Student Login
                        </a>
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
                                <a class="navbar-link has-text-white {{ $rootMenu->css_classes }}" href="{{ url($rootMenu->link_to=='/' ? '/' : '/page'.$rootMenu->link_to) }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                                    {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                                </a>
                                @if(count($children) > 0)
                                    <div class="navbar-dropdown is-boxed">
                                        @foreach($children as $sub)
                                            <a class="navbar-item" href="{{ url($sub->link_to=='/' ? '/' : '/page'.$sub->link_to) }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
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
</div>