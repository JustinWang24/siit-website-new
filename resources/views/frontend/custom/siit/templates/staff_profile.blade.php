@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mt-10 mb-10">

        <div class="content">
            <div class="columns is-marginless">
                <div class="column is-one-quarter left-side-bar-wrap mt-0">
                    <h1 class="mt-20">{{ \App\Models\Staff::GetStaffTypeName($staff->type) }}</h1>
                    <hr>
                    <p class="has-text-centered">
                        <img src="{{ $staff->getAvatarUrl() }}" alt="{{ $staff->name }}">
                    </p>
                    <div class="columns">
                        <div class="column is-3">
                            <p class="has-text-centered">
                                <i class="fa fa-phone"></i>
                            </p>
                        </div>
                        <div class="column">
                            <p>
                                {{ $staff->phone }} <span class="has-text-grey">(Phone)</span>
                            </p>
                            <p>
                                {{ $staff->fax }} <span class="has-text-grey">(Fax)</span>
                            </p>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-3">
                            <p class="has-text-centered">
                                <i class="fas fa-envelope"></i>
                            </p>
                        </div>
                        <div class="column">
                            <p>
                                <a class="has-text-danger" href="mailto:{{ $staff->email }}">{{ $staff->email }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-3">
                            <p class="has-text-centered">
                                <i class="fas fa-map-marker"></i>
                            </p>
                        </div>
                        <div class="column">
                            <p>
                                SIIT {{ $staff->campus->name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="column is-three-quarter">
                    <div class="page-title-wrap">
                        <h1 class="is-size-1-desktop is-size-1-mobile">{{ $staff->name }}</h1>
                        <h2>{{ $staff->job_title }}</h2>
                        <p class="has-text-grey">
                            @if(\App\Models\Staff::GetJobGroupName($staff->job_group) != 'N.A')
                            {{ \App\Models\Staff::GetJobGroupName($staff->job_group) }}
                            @endif
                            @if(\App\Models\Staff::GetDivisionName($staff->division) != 'N.A')
                                - {{ \App\Models\Staff::GetDivisionName($staff->division) }}
                            @endif
                        </p>
                        <hr>
                        {!! $staff->content !!}
                        <hr>
                        <iframe src="https://www.youtube.com/embed/5r5a0vNQjlw" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection