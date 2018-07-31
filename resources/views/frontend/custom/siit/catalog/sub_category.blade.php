@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 pl-10 pr-10 categories-wrapper" id="category-view-manager">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-2 pl-10">{{ $category->getName() }}</h1>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="content pl-20">
                    <ul>
                        @foreach($courses as $p)
                        <li>
                            <p class="">
                                <a href="{{ url('catalog/product/'.$p->uri) }}">
                                    {{ $p->getName() }}
                                </a>
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection