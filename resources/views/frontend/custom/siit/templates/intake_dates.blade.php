@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mt-10 mb-10">

        <div class="content">
            <div class="columns is-marginless">
                <div class="column is-one-fifth left-side-bar-wrap">
                    <h2 class="parent-item">
                        <a href="#" title="Intake dates" style="font-weight: normal;">
                            {{ trans('general.intake_dates_page_title') }}
                        </a>
                    </h2>
                    <h3 class="sibling-item ">
                        <a href="#campus-sydney" title="{{ trans('general.Sydney') }}" style="font-weight: normal;">
                            {{ trans('general.Sydney') }}
                        </a>
                    </h3>
                    <h3 class="sibling-item ">
                        <a href="#campus-melbourne" title="{{ trans('general.Melbourne') }}" style="font-weight: normal;">
                            {{ trans('general.Melbourne') }}
                        </a>
                    </h3>
                    <h3 class="sibling-item ">
                        <a href="#campus-brisbane" title="{{ trans('general.Brisbane') }}" style="font-weight: normal;">
                            {{ trans('general.Brisbane') }}
                        </a>
                    </h3>
                </div>
                <div class="column is-four-fifths">
                    @if(!empty($page->feature_image))
                        <img src="{{ $page->getFeatureImageUrl() }}" alt="{{ $page->title }}" style="width: 100%;">
                    @else
                        <div style="height: 6px;"></div>
                    @endif
                    <div class="page-title-wrap">
                        <h1 style="font-size: 36px;font-weight: bold;font-family: Roboto Condensed, SimHei;">{{ app()->getLocale()=='cn'?$page->title_cn:$page->title }}</h1>
                    </div>
                    <div class="content page-content-wrap">
                        {!! $page->rebuildContent() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection