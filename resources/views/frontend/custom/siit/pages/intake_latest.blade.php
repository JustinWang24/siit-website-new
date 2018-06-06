@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-10 intake-page-app" id="intake-page-app">
        <div class="columns mt-0 pt-0 mb-0 pb-0">
            <div class="column pt-0 pb-0">
                <img src="{{ asset('/images/frontend/intake-date.jpg') }}" alt="Intake date" style="width: 100%;">
            </div>
        </div>

        <div class="content">
            <div class="columns is-marginless">
                <div class="column is-one-quarter left-side-bar-wrap">
                    <h2 class="mt-20 pt-10">Latest Intake Schedule</h2>
                    <hr>
                    @foreach($campuses as $key=>$campus)
                        <h3 class="is-size-4 pl-10"><a href="#campus-section-{{ $key }}">{{ $campus->name }}</a></h3>
                    @endforeach
                </div>
                <div class="column is-three-quarter">

                    <?php
                        $languages = \App\Models\Catalog\IntakeItem::GetSupportedLanguages();
                    ?>

                    @foreach($campuses as $key=>$campus)
                    <div class="page-title-wrap" id="campus-section-{{ $key }}">
                        <h1 class="is-size-3-desktop is-size-3-mobile">{{ $campus->name }} Intake Schedule</h1>
                        <hr>
                    </div>
                    <div class="content page-content-wrap">
                        @foreach($campus->courses as $courseIndex => $course)
                            <table>
                                <thead>
                                <tr><h2 class="has-text-centered is-size-4-desktop is-size-4-mobile">Course: <a href="{{ url('/catalog/product/'.$course->getProductUrl()) }}">{{ $course->name }}</a></h2></tr>
                                <tr>
                                    @foreach($languages as $languageIndex=>$language)
                                    <th>{{ $language }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($course->intakes as $intake)
                                    <tr>
                                        @foreach($intake->intakeItems as $item)
                                        <td class="intake-item-box">
                                            @if($item->seats && $item->seats>$item->enrolment_count && $item->scheduled)
                                            <a class="intake-book-link-btn" href="{{ url('/catalog/course/book/'.$item->id) }}">
                                                <div class="control">
                                                    <div class="tags has-addons">
                                                        <span class="tag">{{ $item->scheduled->format('d/M/Y') }}</span>
                                                        <span class="tag is-success">{{ $item->seats }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                            @endif
                                        </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                    @endforeach
                    <blockquote>
                        Please note: Dates may vary depending on demand. For further information, please visit : <a href="{{ url('') }}">{{ url('') }}</a> or contact admission via email to <a href="mailto:{{ $siteConfig->contact_email }}">{{ $siteConfig->contact_email }}</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
@endsection