@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 pl-10 pr-10 categories-wrapper" id="category-view-manager">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-2 pl-10">{{ trans('general.Courses') }}</h1>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="content pl-20">
                <?php
                foreach ($campuses as $campusName=>$products) {
                ?>
                <h2 class="is-size-4">{{ trans('general.Campus').': '. $campusName }}</h2>

                <ul>
                    @foreach($products as $key=>$product)
                        <li>
                            <p>
                                <a href="{{ url('catalog/product/'.$product->uri) }}">
                                    <p class="is-size-6 has-text-grey mb-10 mh48">{{ $product->name }}</p>
                                </a>
                            </p>
                        </li>
                    @endforeach
                </ul>
                <?php
                }
                ?>
            </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection