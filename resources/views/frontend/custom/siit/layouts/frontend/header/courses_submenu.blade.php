@foreach($categoryTags as $key=>$categoryTag)
    @if($showOnly==$categoryTag->name)
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#" title="{{ app()->getLocale()=='cn' && !empty($categoryTag->name_cn) ? $categoryTag->name_cn : $categoryTag->name }}" style="border-bottom: none;">
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
    @endif
@endforeach
