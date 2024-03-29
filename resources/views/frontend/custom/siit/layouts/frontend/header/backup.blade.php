<div id="navigation-app">
    <div class="header-bg-bar bg-dark-blue">

    </div>
    <nav id="navbar" class="navbar  is-fixed-top bg-dark-blue">
        <div class="container bg-transparent" id="home-nav-header-general">
            <div class="navbar-brand is-marginless bg-dark-blue">
                @if(empty($siteConfig->logo))
                    {{ str_replace('_',' ',env('APP_NAME','Home')) }}
                @else
                    <a id="logo-top" class="" href="{{ url('/') }}" style="margin-top: 11px;">
                        {!! \App\Models\Utils\AMP\MediaUtil::NormalImage(asset($siteConfig->logo_dark),'SIIT: a bridge across cultures', '50%', null, 'image') !!}
                    </a>
                @endif
            </div>
            <div id="navDesktopWrap" class="full-width is-marginless bg-dark-blue">
                <div class="navbar-menu">
                    <div class="navbar-end sm-nav">
                        @if(empty(session('user_data')))
                            <a class="navbar-item has-text-white" href="{{ url('/frontend/customers/login') }}" title="{{ trans('general.student_login') }}">
                                <i class="fas fa-sign-in-alt"></i>&nbsp;{{ trans('general.student_login') }}
                            </a>
                        @elseif(!empty(session('user_data.uuid')))
                            <a class="navbar-item has-text-white" href="{{ url('/frontend/my_profile/'.session('user_data.uuid')) }}" title="{{ trans('general.my_dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>&nbsp;{{ trans('general.my_dashboard') }}
                            </a>
                            <a class="navbar-item has-text-white" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="{{ trans('general.menu_logout') }}">
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
                                                                <i class="fas fa-plus has-text-link" style="margin-left: -4px;"></i>
                                                                &nbsp;&nbsp;{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                                            </a>
                                                            <ul id="pathway-list-subs" class="hidden" style="margin-top: 0;margin-left: 8px;">
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
                        <div class="navbar-item">
                            <a class="has-text-white" href="{{ url('/switch-language/'.(app()->getLocale()=='cn' ? 'en':'cn')) }}" title="{{ trans('general.switch_language') }}">
                                {{ trans('general.switch_language') }}
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
</div>