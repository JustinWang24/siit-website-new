@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <section class="section is-paddingless company-brief-wrap">
        <div class="container">
            <div class="columns is-marginless">
                <div class="column is-three-quarters first-visiting">
                    <h2>FIRST</h2>
                    <h2>TIME <span class="super-bold">Visiting</span></h2>
                    <br>
                    <div class="columns mt-20">
                        <div class="column">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed nulla mollis, ornare mi ac, consequat velit. Pellentesque nec fringilla nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce dignissim rutrum lorem, bibendum vehicula orci commodo non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam nec pulvinar ligula. Sed odio felis, pulvinar nec pretium in
                            </p>
                        </div>
                        @foreach($topStories as $key=>$blog)
                            @if($key < 2)
                        <div class="column">
                            <div class="card">
                                <div class="card-image">
                                    <figure>
                                        <img src="{{ $blog->getFeatureImageUrl() }}" alt="{{ $blog->title }}">
                                    </figure>
                                </div>
                                <div class="card-content pl-0">
                                    <div class="media">
                                        <div class="media-content">
                                            <p class="title is-4">{{ $blog->title }}</p>
                                            <p class="subtitle is-6"><i>{{ $blog->title_cn }}</i></p>
                                            <p class="mt-10 has-text-grey-light">{!! $blog->teasing !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="column is-paddingless first-visiting-sidebar">
                    <div class="content">
                        @foreach(range(1,3) as $key)
                            <div class="box">
                                <h4>89%</h4>
                                <h5>OF CLASS OF 2017</h5>
                                <p>Consectetur adipiscing elit, Consectetur adipiscing elit</p>
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
                        @foreach($topStories as $key=>$blog)
                            @if($key > 1)
                                <div class="column">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure>
                                                <img src="{{ $blog->getFeatureImageUrl() }}" alt="{{ $blog->title }}">
                                            </figure>
                                        </div>
                                        <div class="card-content pl-0">
                                            <div class="media">
                                                <div class="media-content">
                                                    <p class="title is-4">{{ $blog->title }}</p>
                                                    <p class="subtitle is-6"><i>{{ $blog->title_cn }}</i></p>
                                                    <p class="mt-10 has-text-grey-light">{!! $blog->teasing !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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

    <section class="section is-paddingless we-social-wrap">

        <div class="container">
            <div class="columns is-marginless">
                <div class="column first-visiting">
                    <h2>WE</h2>
                    <h2>ARE</h2>
                    <h2><span class="super-bold">SOCIAL</span></h2>
                </div>
                <div class="column is-half">
                    <div class="box social-msg mt-20">
                        <p>Duis pretium felis at dui fringilla convallis. Phasellus eleifend sollicitudin</p>
                        <p class="has-text-right has-text-grey-light">1 day ago</p>
                    </div>
                    <div class="box social-msg">
                        <p>Duis pretium felis at dui fringilla convallis. Phasellus eleifend sollicitudin</p>
                        <p class="has-text-right has-text-grey-light">2 days ago</p>
                    </div>
                </div>
                <div class="column ">
                    <br>
                    <div class="box facebook-btn mt-20">
                        <a href="#">
                            <i class="fab fa-facebook-f"></i>&nbsp;SIIT FACEBOOK
                        </a>
                    </div>
                    <div class="box twitter-btn">
                        <a href="#">
                            <i class="fab fa-twitter"></i>&nbsp;FOLLOW SIIT
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection