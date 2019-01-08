@extends('layouts.backend')
@section('content')
    <div class="content">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    {{ trans('admin.menu.leads') }} {{ trans('admin.mgr') }} ({{ $leads->total() }})
                </h2>
            </div>
            <div class="column">
            </div>
        </div>

        <div class="container">
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th width="120">Name</th>
                    <th width="120">Contact</th>
                    <th width="120">Date</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leads as $key=>$value)
                    <tr>
                        <td>
                            {{ $value->name }}
                        </td>
                        <td>
                            <p><a href="mailto:{{ $value->email }}">{{ $value->email }}</a></p>
                            <p>{{ $value->phone }}</p>
                        </td>
                        <td>
                            {{ $value->created_at->format('d-M-Y') }}
                        </td>
                        <td>
                            {!! $value->message !!}
                        </td>
                        <td>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/leads/delete/'.$value->id) }}">
                                <i class="fa fa-trash"></i>&nbsp;Del
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $leads->links() }}
        </div>
    </div>
@endsection