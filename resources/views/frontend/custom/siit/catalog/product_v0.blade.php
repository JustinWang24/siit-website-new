@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 product-view-manager-app" id="product-view-manager-app">
        <div class="content">
            <div class="columns is-marginless">
                <div class="column is-one-quarter left-side-bar-wrap" style="margin-top: 1px;">
                    @include(_get_frontend_theme_path('catalog.elements.sections.course_attributes_list'))
                </div>
                <div class="column is-three-quarter product-info-wrap">
                    <div class="slick-carousel-el" id="slick-carousel-el-">
                        @foreach($product_images as $idx=>$media)
                            <img class="" src="{{ $media->url }}" alt="{{ $product->name.$idx }}" />
                        @endforeach
                    </div>
                    <div class="content pl-20 pr-20">
                        <h1 class="mt-20" style="font-size: 21px;">
                            {{ trans('general.Course') }} {{ trans('general.name') }}: {{ app()->getLocale() == 'cn' ? $product->name_cn : $product->name }}&nbsp;
                            @if($product->manage_stock && $product->stock<$product->min_quantity)
                                <span class="badge badge-pill badge-danger">Out of Stock</span>
                            @endif
                        </h1>
                        <hr>
                        <h2 class="is-size-5 has-text-danger">{{ trans('general.Campus') }}: {{ $product->brand }}</h2>
                        @include(_get_frontend_theme_path('catalog.elements.sections.short_description'))

                        <div class="main-attributes content">
                            @include(_get_frontend_theme_path('catalog.elements.sections.attributes_main'))
                        </div>

                        @include(_get_frontend_theme_path('catalog.elements.sections.price'))

                        <form id="add-to-cart-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{ $product->uuid }}">
                            <input type="hidden" name="user_id" value="{{ session('user_data.uuid') }}">

                            @if(count($product_colours)>0)
                                <div class="options-wrap">
                                    @include(_get_frontend_theme_path('catalog.elements.sections._options.colour'))
                                </div>
                            @endif

                            @if(count($product_options)>0)
                                <div class="options-wrap">
                                    @include(_get_frontend_theme_path('catalog.elements.sections.options'))
                                </div>
                            @endif

                            <div class="row">
                                <?php
                                    $languages = \App\Models\Catalog\IntakeItem::GetSupportedLanguages();
                                    $today = \Carbon\Carbon::today();
                                ?>
                                    <hr>
                                    <table>
                                        <thead>
                                        <tr>
                                            <h2 class="is-size-4-desktop is-size-4-mobile has-text-grey">
                                                {{ trans('general.Proposed_Language') }} <span class="has-text-link">({{ trans('general.Please_choose_language') }})</span></h2></tr>
                                        <tr>
                                        @foreach($languages as $languageIndex=>$language)
                                            <th>{{ trans('general.'.$language) }}</th>
                                        @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($product->intakes as $intake)
                                            <tr>
                                                @foreach($intake->intakeItems as $item)
                                                    @if($item->scheduled > $today)
                                                    <td class="intake-item-box">
                                                        @if($item->seats && $item->seats>$item->enrolment_count && $item->scheduled)
                                                            <a class="intake-book-link-btn" href="{{ url('/catalog/course/book/'.$item->id) }}" title="Click me to enroll now!">
                                                            </a>
                                                            <p>
                                                                <span class="tag is-success seats-select-tag" :class="{'item-selected':intakeItemId==<?php echo $item->id ?>}" v-on:click="chooseIntakeItem({{ $item->id }})">
                                                                    {{ $item->seats }} Seats&nbsp;<span v-html="(intakeItemId=={{$item->id}}?'&#10004;':'')"></span>
                                                                </span>
                                                            </p>
                                                        @endif
                                                    </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                            </div>
                            <div class="row">
                                <h2 class="is-size-4-desktop is-size-4-mobile has-text-grey mt-10">{{ trans('general.Scheduled_Intake') }}</h2>
                                <el-select v-model="selectedAxcelerateInstanceId" placeholder="{{ trans('general.Please_choose_intake') }}" class="full-width">
                                    <el-option
                                            v-for="(item,idx) in axcelerateInstances"
                                            :key="idx"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="add-to-cart-form-wrap">
                                <input type="hidden" name="quantity" value="1"><!-- 一次报名1人 -->
                                <button v-on:click="enrollNow($event)" type="submit" class="button is-danger" :disabled="selectedAxcelerateInstanceId.length==0 || intakeItemId==0">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{{ trans('general.Enroll_Now') }}
                                </button>
                            </div>
                        </form>
                        <blockquote class="mt-20">
                            <p>
                                {{ trans('general.help_notes') }}
                            </p>
                            <p>{{ trans('general.Email_to') }} <a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a> {{ trans('general.or_call') }} <span class="has-text-link">{{ $siteConfig->contact_phone }}</span></p>
                        </blockquote>
                    </div>

                    <div class="content pr-20">
                        @include(_get_frontend_theme_path('catalog.elements.sections.description'))
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection