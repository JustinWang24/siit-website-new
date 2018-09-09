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
                            {{ trans('general.Course') }}{{ trans('general.name') }}: {{ app()->getLocale() == 'cn' ? $product->name_cn : $product->name }}&nbsp;
                            @if($product->manage_stock && $product->stock<$product->min_quantity)
                                <span class="badge badge-pill badge-danger">Out of Stock</span>
                            @endif
                        </h1>
                        <hr>
                        <h2 class="is-size-5 has-text-danger">{{ trans('general.Campus') }}: {{ trans('general.'.$product->brand) }}</h2>
                        @include(_get_frontend_theme_path('catalog.elements.sections.short_description'))

                        <div class="main-attributes content">
                            @include(_get_frontend_theme_path('catalog.elements.sections.attributes_main'))
                        </div>

                        @include(_get_frontend_theme_path('catalog.elements.sections.price'))

                        <form id="add-to-cart-form" method="post" action="{{ route('course.book') }}/unax-">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{ $product->uuid }}">
                            <input type="hidden" name="user_id" value="{{ session('user_data.uuid') }}">
                            <input type="hidden" name="agent" value="{{ $agentCode }}">

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

                            <div class="row mt-20">
                                <h2 class="is-size-4-desktop is-size-4-mobile has-text-grey mt-10">{{ trans('general.Scheduled_Intake') }}</h2>
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label has-text-left" style="font-size: 18px;">{{ trans('general.Intake') }}</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <div class="select full-width">
                                                    <select class="select full-width" name="intake_id">
                                                        @foreach($product->intakes as $key=>$intake)
                                                            <option value="{{ $intake->id }}">
                                                                {{ $intake->title }}
                                                                {{ $intake->online_date->format('d/M/Y') }} - {{ $intake->offline_date->format('d/M/Y') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="add-to-cart-form-wrap">
                                <input type="hidden" name="quantity" value="1"><!-- 一次报名1人 -->
                                <button type="submit" class="button is-danger">
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