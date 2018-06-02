@extends('layouts.backend')
@section('content')
    <div id="">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    Staff {{ trans('admin.mgr') }} ({{ $pages->total() }})
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/staff/add') }}"><i class="fa fa-plus"></i>&nbsp;New Staff</a>
            </div>
        </div>

        <div class="container">
            <?php
            $campusArray = [];
            foreach ($allCampus as $item) {
                $campusArray[$item->id] = $item->name;
            }
            ?>
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Job Title</th>
                    <th>Campus</th>
                    <th>Type</th>
                    <th>Division</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $key=>$value)
                    <tr>
                        <td>
                            <a href="#" target="_blank">
                                <img src="{{ $value->getAvatarUrl() }}" alt="" class="image" style="width: 70px;">
                            </a>
                        </td>
                        <td>
                            {{ $value->name }}
                        </td>
                        <td>
                            {{ \App\Models\Staff::GetJobGroupName($value->job_group) }}
                        </td>
                        <td>
                            {{ isset($campusArray[$value->brand_id]) ? $campusArray[$value->brand_id] : null }}
                        </td>
                        <td>
                            {{ \App\Models\Staff::GetStaffTypeName($value->type) }}
                        </td>
                        <td>{{ \App\Models\Staff::GetDivisionName($value->division) }}</td>
                        <td>
                            <a href="mailto:{{ $value->email }}">{{ $value->email }}</a>
                        </td>
                        <td>
                            <a href="tel:{{ $value->phone }}">{{ $value->phone }}</a>
                        </td>
                        <td>
                            {!! $value->status ? '<span class="tag is-success">In-service</span>' : '<span class="tag is-danger">Departure</span>' !!}
                        </td>
                        <td>
                            <a class="button is-small" href="{{ url('backend/staff/edit/'.$value->id) }}">
                                <i class="fa fa-edit"></i>&nbsp;Edit
                            </a>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/staff/delete/'.$value->id) }}">
                                <i class="fa fa-trash"></i>&nbsp;Del
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $pages->links() }}
        </div>
    </div>
@endsection