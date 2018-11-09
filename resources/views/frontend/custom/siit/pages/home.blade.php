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
                <div class="column first-visiting">
                    <h2>STORY OF SUCCESS</h2>
                    <br>
                    <div class="box">
                        <h3>SIIT - A BRIDGE ACROSS CULTURES</h3>
                        <div class="columns">
                            <div class="column">
                                <p>Sydney Institute of Interpreting and Translating (SIIT) is a registered training organisation with campuses in Brisbane, Melbourne and Sydney.</p>
                                <p>The academic programs offered at SIIT, including NAATI Endorsed Diploma of Interpreting, Advanced Diploma of Interpreting, Advanced Diploma of Translating, are built around the needs of the students.</p>
                                <p>The growing “ever-smaller” global village, where exchanges of information across languages and cultures now occur across all spheres of human society, leads to an increasing demand for the services of professional interpreters and translators, supervisors, coordinators and teachers etc.
                                </p>
                            </div>
                            <div class="column">
                                <p> Over the last ten years, SIIT has seen more than Fifteen Thousand graduates working in a variety of industries around the globe making use of its skills and knowledge gained at SIIT across a variety of language streams include Mandarin, Cantonese, Hindi, Punjabi, Nepali, Korean and Vietnamese.</p>
                                <p>SIIT has provided interpreters for a variety of industry groups over the years.</br>
                                    2016 SIIT provided 150 Mandarin-speaking interpreters to the Sino-Australian Agriculture Forum held in Sydney.</p>
                                <p>SIIT graduates and trainers and assessors acted as interpreters for numerous high-level business meetings between China and Australia.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection