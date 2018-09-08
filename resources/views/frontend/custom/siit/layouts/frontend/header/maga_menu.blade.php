<div class="menu-container">
    <div class="container menu">
        <ul>
            <li>
                <a href="/" title="{{ trans('general.menu_home') }}">
                    {{ trans('general.menu_home') }}
                </a>
            </li>
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
                    <ul>
                        @foreach($categoryTags as $key=>$categoryTag)
                        <li>
                            <a class="is-size-5-desktop is-link" href="#" title="{{ app()->getLocale()=='cn' && !empty($categoryTag->name_cn) ? $categoryTag->name_cn : $categoryTag->name }}">
                                {{ app()->getLocale()=='cn' && !empty($categoryTag->name_cn) ? $categoryTag->name_cn : $categoryTag->name }}
                            </a>
                            @if(count($categoryTag->children) > 0)
                            <ul>
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
                                                    <a class="has-low-level-menus" data-content="#pathway-list-subs{{ $randomString }}" href="#" title="{{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}">
                                                        <i class="fas fa-plus has-text-grey" style="margin-left: 0;font-size: 12px;"></i>
                                                        <i class="fas fa-minus has-text-grey" style="margin-left: 0;font-size: 12px;display: none;"></i>
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
                                        <a href="#" title="{{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}">
                                            {{ app()->getLocale()=='cn' && !empty($subCategory->name_cn) ? $subCategory->name_cn : $subCategory->name }}
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach

                        <?php
                        $children = $rootMenu->getSubMenus();
                        ?>
                        <li>
                        <a class="is-size-5-desktop is-link" href="{{ $rootMenu->link_to=='/' ? '/' : $rootMenu->getMenuUrl() }}" title="{{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}">
                            {{ app()->getLocale()=='cn' && !empty($rootMenu->name_cn) ? $rootMenu->name_cn : $rootMenu->name }}
                        </a>
                        @if(count($children) > 0)
                            <ul>
                                @foreach($children as $sub)
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
                                @endforeach
                            </ul>
                        @endif
                        </li>
                    </ul>
                @endif
                </li>
            @endforeach
            <li>
                <a href="{{ url('/switch-language/'.(app()->getLocale()=='cn' ? 'en':'cn')) }}" title="{{ trans('general.switch_language') }}">
                    {{ trans('general.switch_language') }}
                </a>
            </li>
        </ul>
    </div>
</div>