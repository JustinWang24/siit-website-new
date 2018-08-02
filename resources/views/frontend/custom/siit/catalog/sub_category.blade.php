@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 pl-10 pr-10 categories-wrapper" id="category-view-manager">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-3 pl-10 has-text-centered">{{ $category->getName() }}</h1>
            </div>
        </div>

        <div class="columns">
            <div class="column">
            @foreach($courses as $p)
                <div class="card mb-20">
                    <h2 class="is-size-5 ml-20 mt-20 pt-20">
                        <a href="{{ url('catalog/product/'.$p->uri) }}">
                            {{ $p->getName() }} - {{ $p->brand }} {{ trans('general.Campus') }}
                        </a>
                    </h2>
                    <div class="card-content">
                        <div class="content pl-20">
                        {!! $p->getShortDescription() !!}
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection