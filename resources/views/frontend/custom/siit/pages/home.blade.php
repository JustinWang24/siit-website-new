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
                                    <a href="{{ url('/page'.$blog->uri) }}"><img style="min-height: 180px;" src="{{ $blog->getFeatureImageUrl() }}" alt="{{ app()->getLocale() == 'cn' ? $blog->title  : $blog->title_cn  }}"></a>
                                </div>
                                <div class="card-content pl-0">
                                    <div class="media">
                                        <div class="media-content">
                                            <a href="{{ url('/page'.$blog->uri) }}"><p class="title is-4" style="font-size: 14px;">{{ app()->getLocale() == 'cn' ? $blog->title  : $blog->title_cn }}</p></a>
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
                                <a href="{{ url('/page/events'.$event->uri) }}"><h4 style="margin-bottom: 0.3em;font-size: 24px;">{{ $event->title }}</h4></a>
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
                                            <a href="{{ url('/page'.$blog->uri) }}"><img src="{{ $blog->getFeatureImageUrl() }}" alt="{{ app()->getLocale() == 'cn' ? $blog->title  : $blog->title_cn  }}"></a>
                                        </figure>
                                    </div>
                                    <div class="pl-0">
                                        <div class="media">
                                            <div class="media-content">
                                                <a href="{{ url('/page'.$blog->uri) }}"><p class="title is-4" style="font-size: 14px;">{{ app()->getLocale() == 'cn' ? $blog->title  : $blog->title_cn  }}</p></a>
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
                        <img src="{{ asset('/images/frontend/custom/smile1.jpg') }}" alt="" class="image">
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
                        <h3>Consectetur adipiscing elit, Consectetur adipiscing elit</h3>
                        <div class="columns">
                            <div class="column">
                                <p>
                                    Duis pretium felis at dui fringilla convallis. Phasellus eleifend sollicitudin vestibulum. Nulla faucibus urna sed porta efficitur. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut maximus arcu non nisl pulvinar egestas. Quisque vestibulum, purus ac rutrum accumsan, ipsum tellus commodo diam, non tristique felis ante et eros. Aenean blandit fringilla purus, in aliquet enim mattis eget.
                                </p>
                            </div>
                            <div class="column">
                                <p>
                                    Duis pretium felis at dui fringilla convallis. Phasellus eleifend sollicitudin vestibulum. Nulla faucibus urna sed porta efficitur. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut maximus arcu non nisl pulvinar egestas. Quisque vestibulum, purus ac rutrum accumsan, ipsum tellus commodo diam, non tristique felis ante et eros. Aenean blandit fringilla purus, in aliquet enim mattis eget.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection