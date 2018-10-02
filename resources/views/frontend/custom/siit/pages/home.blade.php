@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <section class="section is-paddingless company-brief-wrap" style="background-color: #06162f;">
        <div class="container" style="background-color: transparent;">
            <div class="columns is-marginless">
                <div class="column is-three-quarters first-visiting">
                    <h2>FIRST</h2>
                    <h2>TIME VISITING</h2>
                    <br>
                    <div class="columns mt-20">
                        @foreach($topStories as $key=>$blog)
                            @if($key < 3)
                        <div class="column">
                            <div class="card">
                                <div class="card-image">
                                    <a href="{{ url('/page'.$blog->uri) }}"><img style="height: 180px;" src="{{ $blog->getFeatureImageUrl() }}" alt="{{ app()->getLocale() == 'cn' ? $blog->title_cn  : $blog->title  }}"></a>
                                </div>
                                <div class="card-content pl-0">
                                    <div class="media">
                                        <div class="media-content">
                                            <a href="{{ url('/page'.$blog->uri) }}"><p class="title is-4" style="font-size: 14px;">{{ app()->getLocale() == 'cn' ? $blog->title_cn  : $blog->title }}</p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="column is-paddingless first-visiting-sidebar d-flex">
                    <div class="content align-self-center" style="margin: 0 auto;">
                        @foreach($latestEvents as $key=>$event)
                            <div class="box">
                                <a href="{{ url('/page/events'.$event->uri) }}"><h4 style="margin-bottom: 0.3em;font-size: 20px;">{{ $event->title }}</h4></a>
                                <i class="far fa-clock fa-fw" style="color: #fff;"></i><time datetime="2016-1-1" style="color: #ffffff;">{{ $event->start->format('H:i A - d M Y') }}</time>
                                <p><i class="far fa-file-alt fa-fw" style="color: #fff;"></i>{!! $event->teasing !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section is-paddingless campus-life-wrap">
        <div class="container">
            <div class="columns is-marginless">
                <div class="column first-visiting">
                    <h2>CAMPUS</h2>
                    <h2><span class="super-bold">LIFE</span></h2>
                    <br>
                    <div class="columns mt-20">
                        @foreach($latestNews as $key=>$blog)
                            <div class="column">
                                <div class="card">
                                    <div class="card-image">
                                        <figure>
                                            <a href="{{ url('/page'.$blog->uri) }}"><img src="{{ $blog->getFeatureImageUrl() }}" alt="{{ app()->getLocale() == 'cn' ? $blog->title_cn  : $blog->title  }}"></a>
                                        </figure>
                                    </div>
                                    <div class="pl-0">
                                        <div class="media">
                                            <div class="media-content">
                                                <a href="{{ url('/page'.$blog->uri) }}"><p class="title is-4" style="font-size: 14px;">{{ app()->getLocale() == 'cn' ? $blog->title_cn  : $blog->title  }}</p></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="column is-paddingless">
                    <div class="content">
                        <img src="{{ asset('/images/frontend/custom/smile1.jpg') }}" alt="New Brochure" class="image">
                        <div class="box is-paddingless brochure-box">
                            <h2><i>Get 2018 New Brochure</i></h2>
                            <div class="view-more-btn">
                                View website for more information
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section is-paddingless story-success-wrap">
        <div class="container">
            <div class="columns is-marginless">
                <div class="column is-two-thirds first-visiting">
                    <h2>STORY</h2>
                    <h2>OF</h2>
                    <h2><span class="super-bold">SUCCESS</span></h2>
                    <br>
                    <div class="box">
                        <h3>APEI - A Step Stone to Professional Career</h3>
                        <div class="columns">
                            <p style="padding-left: 1em">
                                Australian Professional Education Institute Pty Ltd trading as Sydney Institute of Interpreting and Translating (SIIT) was established as a registered training organization in April 2009.
                            </p>
                            <p style="padding-left: 1em">The growing “ever-smaller” global village, where exchanges of information across languages and cultures now occur across all spheres of human society, leads to an increasing demand for the services of professional interpreters and translators.
                            </p>
                            <p style="padding-left: 1em" >SIIT was established for the purpose of training qualified interpreters and translators across a variety of language streams. And SIIT has been dedicated to this mission of producing professional interpreters and translators.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection