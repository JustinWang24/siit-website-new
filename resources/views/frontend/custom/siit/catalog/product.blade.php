@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20" id="product-view-manager-app">
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
                        <br>
                        <h2>
                            Course name: {{ $product->name }}&nbsp;
                            @if($product->manage_stock && $product->stock<$product->min_quantity)
                                <span class="badge badge-pill badge-danger">Out of Stock</span>
                            @endif
                        </h2>
                        <p class="sku-txt">SKU: {{ $product->sku }}</p>

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

                            <div class="add-to-cart-form-wrap">
                                <div class="field mb-20">
                                    <label class="label">
                                        Quantity
                                        @if(!empty($product->unit_text))
                                            <span class="has-text-danger is-size-7">(Unit: {{ $product->unit_text }})</span>
                                        @endif
                                    </label>
                                    <div class="control quantity-input-wrap">
                                        <input
                                                data-name="quantity"
                                                name="quantity"
                                                type="number"
                                                class="input quantity-input"
                                                placeholder="Quantity"
                                                value="{{ $product->min_quantity }}"
                                                min="{{ $product->min_quantity }}"
                                        >
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">
                                        Notice: Minimum quantity is <strong>{{ $product->min_quantity }}{{ !empty($product->unit_text)?' '.$product->unit_text:null }}</strong> per order.
                                    </small>
                                </div>
                                @if(!$product->manage_stock)
                                    <button v-on:click="addToCartAction($event)" id="add-to-cart-btn" type="submit" class="button is-danger">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                    </button>
                                    <a href="{{ url('/frontend/place_order_checkout') }}" id="shortcut-checkout-btn" class="button is-link shortcut-checkout-btn is-invisible">
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Checkout Now!
                                    </a>
                                @else
                                    @if($product->stock<$product->min_quantity)
                                        <button id="send-enquiry-for-shopping-btn" type="submit" class="button">Send Enquiry</button>
                                    @else
                                        <button id="add-to-cart-btn" type="submit" class="button add-to-cart-btn">Add to Cart</button>
                                    @endif
                                @endif
                            </div>
                        </form>
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