<nav id="menu" class="menu slideout-menu slideout-menu-left">
    <section class="menu-section">
        @if(empty($siteConfig->logo))
            <h3 class="menu-section-title">{{ str_replace('_',' ',env('APP_NAME','Home')) }}</h3>
        @else
            <img src="{{ asset($siteConfig->logo_dark ? $siteConfig->logo_dark : $siteConfig->logo) }}" alt="Logo" class="logo-img-mobile">
        @endif
    </section>
    <!-- e-commerce -->
    @if(empty(session('user_data')))
        <section class="menu-section mb-10 mt-10">
            <a class="has-text-white navbar-item" href="{{ url('/frontend/customers/login') }}" title="{{ trans('general.student_login') }}">
                <i class="fas fa-sign-in-alt"></i>   {{ trans('general.student_login') }}
            </a>
        </section>
    @elseif(!empty(session('user_data.uuid')))
        <section class="menu-section mb-10 mt-10">
            <ul class="menu-section-list">
                <li>
                    <a class="has-text-grey-light"  href="{{ url('/frontend/my_profile/'.session('user_data.uuid')) }}" title="{{ trans('general.my_dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>&nbsp;{{ trans('general.my_dashboard') }}
                    </a>
                </li>
                <li>
                    <a class="has-text-grey-light"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="{{ trans('general.menu_logout') }}">
                        <i class="fas fa-sign-out-alt"></i>&nbsp;{{ trans('general.menu_logout') }}
                    </a>
                </li>
            </ul>
        </section>
    @endif
    @if(isset($categoriesTree) && count($categoriesTree) > 0)
        <section class="menu-section mb-10 mt-10">
        <a class="has-text-white navbar-item" href="#">
            Catalog
        </a>
        </section>
    @endif
    <!-- e-commerce end -->
    @foreach($rootMenus as $key=>$rootMenu)
        <section class="menu-section mb-10 mt-10">
        <?php
        $tag = $rootMenu->html_tag;
        $children = $rootMenu->getSubMenus();
        if($tag && $tag !== 'a'){
            echo '<'.$tag.'>';
        }
        ?>
        @if(count($children) == 0)
            <a class="has-text-white {{ $rootMenu->css_classes }}" href="{{ url($rootMenu->link_to=='/' ? '/' : '/page'.$rootMenu->link_to) }}">
                {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
            </a>
        @else
            <h3 class="menu-section-title">
                <a class="has-text-white" href="{{ url($rootMenu->link_to=='/' ? '/' : '/page'.$rootMenu->link_to) }}">
                    {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                </a>
            </h3>
            <ul class="menu-section-list">
                @foreach($children as $sub)
                    @if($sub->link_to == '/offer-acceptance-and-payment')
                        <li>
                            <a class="has-text-grey-light" href="{{ url('/page/offer-acceptance-and-payment') }}">
                                {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="has-text-grey-light" href="{{ url($sub->link_to==('/frontend/customers/login' || 'https://apei.moodle.com.au/') ? $sub->link_to : '/page'.$sub->link_to) }}">
                                {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
        <?php
        if($tag && $tag !== 'a'){
            echo '</'.$tag.'>';
        }
        ?>
        </section>
    @endforeach

    <section class="menu-section mb-10 mt-10">
        <a class="has-text-white navbar-item" href="{{ url('contact-us') }}">
            {{ trans('general.menu_contact') }}
        </a>
    </section>
</nav>