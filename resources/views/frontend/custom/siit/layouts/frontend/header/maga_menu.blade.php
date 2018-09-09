<div class="menu-container">
    <div class="container menu">
        <ul>
            <li>
                <a href="{{ url('/switch-language/'.(app()->getLocale()=='cn' ? 'en':'cn')) }}" title="{{ trans('general.switch_language') }}">
                    {{ trans('general.switch_language') }}
                </a>
            </li>
            @php
                $rootMenus = $rootMenus->reverse();
            @endphp
            @foreach($rootMenus as $key=>$rootMenu)
                <li>
                @if($rootMenu->name != 'Future Students')
                    <?php
                    $children = $rootMenu->getSubMenus();
                    ?>
                    <a class="navbar-link" href="{{ $rootMenu->link_to=='/' ? '/' : $rootMenu->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                        {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                    </a>
                    @if(count($children) > 0)
                    <ul>
                        @foreach($children as $sub)
                            @php
                                $menuUrl = $sub->getMenuUrl();
                                $pathwaySubmenu = strpos($menuUrl,'University-Pathway-Collection') !== false;
                            @endphp
                            <li>
                                <a href="{{ $sub->link_to=='/' ? '/' : $sub->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                    {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                @else
                    <a class="navbar-link" href="{{ $rootMenu->link_to=='/' ? '/' : $rootMenu->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                        {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                    </a>
                    <ul style="width: 60.5%;margin-left: 15%;">
                        <?php
                        $children = $rootMenu->getSubMenus();
                        ?>
                        <li style="width: 50%;">
                            <a class="is-size-5-desktop" style="color: #3273dc;" href="#" title="{{ trans('general.Local_Students') }}">
                                {{ trans('general.Local_Students') }}
                            </a>
                            @if(count($children) > 0)
                            <ul>
                                @include(_get_frontend_layout_path('frontend.header.courses_submenu'), ['showOnly' => 'Courses'])
                                @foreach($children as $sub)
                                    @if($sub->name!='University Pathways' && $sub->name!='Documents and Forms' && $sub->name!='Education Agent')
                                    @php
                                        $menuUrl = $sub->getMenuUrl();
                                    @endphp
                                    <div class="aside">
                                        <ul class="menu-list">
                                            <li>
                                                <a href="{{ $sub->link_to=='/' ? '/' : $sub->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                                    {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                @endforeach
                            </ul>
                            @endif
                        </li>

                        <li style="width: 50%;">
                            <a class="is-size-5-desktop" style="color: #3273dc;" href="#" title="{{ trans('general.International_Students') }}">
                                {{ trans('general.International_Students') }}
                            </a>
                            @if(count($children) > 0)
                                <ul>
                                    @include(_get_frontend_layout_path('frontend.header.courses_submenu'), ['showOnly' => 'Courses for International Students'])
                                    @foreach($children as $sub)
                                        @if(count($sub->children)>0)
                                            <div class="navbar-item has-dropdown is-hoverable">
                                                <a class="navbar-link" href="#" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}" style="border-bottom: none;">
                                                    {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                                </a>
                                                <div class="navbar-dropdown is-boxed" style="min-width: 95%;">
                                                    @foreach($sub->children as $subChild)
                                                    <a  style="border-bottom: none;" class="navbar-item" href="{{ $subChild->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($subChild->name_cn) ? $subChild->name_cn : $subChild->name }}">
                                                        {{ app()->getLocale()=='cn' && !empty($subChild->name_cn) ? $subChild->name_cn : $subChild->name }}
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            @php
                                                $menuUrl = $sub->getMenuUrl();
                                                $pathwaySubmenu = strpos($menuUrl,'University-Pathway-Collection') !== false;
                                            @endphp
                                            <div class="aside">
                                                <ul class="menu-list">
                                                    <li>
                                                        <a href="{{ $sub->link_to=='/' ? '/' : $sub->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}">
                                                            {{ app()->getLocale()=='cn' && !empty($sub->name_cn) ? $sub->name_cn : $sub->name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    </ul>
                @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>