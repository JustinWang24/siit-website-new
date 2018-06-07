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
                        <h1 class="mt-20">
                            Course name: {{ $product->name }}&nbsp;
                            @if($product->manage_stock && $product->stock<$product->min_quantity)
                                <span class="badge badge-pill badge-danger">Out of Stock</span>
                            @endif
                        </h1>
                        <hr>
                        <h2 class="is-size-5 has-text-danger">Campus: {{ $product->brand }}</h2>
                        <p class="sku-txt">CODE: {{ $product->sku }}</p>

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
//                                dump($product->getFutureIntakes());
                                    $languages = \App\Models\Catalog\IntakeItem::GetSupportedLanguages();
                                    $today = \Carbon\Carbon::today();
                                ?>
                                    <hr>
                                    <table>
                                        <thead>
                                        <tr><h2 class="is-size-4-desktop is-size-4-mobile has-text-grey">Proposed Intake Date <span class="has-text-link">(Click intake date to enroll)</span></h2></tr>
                                        <tr>
                                            @foreach($languages as $languageIndex=>$language)
                                                <th>{{ $language }}</th>
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
                                                                <div class="control">
                                                                    <div class="tags has-addons">
                                                                        <span class="tag">{{ $item->scheduled->format('d/M/Y') }}</span>
                                                                        <span class="tag is-success">{{ $item->seats }}</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                            </div>
                            <div class="add-to-cart-form-wrap is-invisible">
                                <input type="hidden" name="quantity" value="1"><!-- 一次报名1人 -->
                                @if(!$product->manage_stock)
                                    <button v-on:click="addToCartAction($event)" id="add-to-cart-btn" type="submit" class="button is-danger">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Enroll Now
                                    </button>
                                    <a href="{{ url('/frontend/place_order_checkout') }}" id="shortcut-checkout-btn" class="button is-link shortcut-checkout-btn is-invisible">
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Checkout Now!
                                    </a>
                                @else
                                    @if($product->stock<$product->min_quantity)
                                        <button id="send-enquiry-for-shopping-btn" type="submit" class="button">Send Enquiry</button>
                                    @else
                                        <button id="add-to-cart-btn" type="submit" class="button add-to-cart-btn">Enroll Now</button>
                                    @endif
                                @endif
                            </div>
                        </form>
                        <blockquote class="mt-10">Note: students are encouraged to contact SIIT Marketing team for exact timetable and training arrangement.</blockquote>
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