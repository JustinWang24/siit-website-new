@extends('layouts.dealer_portal')
@section('content')
    <div class="container">
        <br>
        <div class="content">
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <h2 class="is-size-4">
                            Orders {{ trans('admin.mgr') }} ({{ $groupOrders->total() }})
                        </h2>
                    </div>
                    <div class="column"></div>
                </div>
                <table class="table full-width is-hoverable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groupOrders as $key=>$value)
                        <tr class="align-middle">
                            <td>{{ $key+1 }}</td>
                            <td>
                                <a target="_blank" href="{{ url('catalog/product/'.$value->uri) }}">
                                    <p>{{ $value->student->name }}</p>
                                </a>
                            </td>
                            <td>
                                <a href="mailto:{{ $value->student->email }}">{{ $value->student->email }}</a>
                            </td>
                            <td>
                                {{ $value->student->phone }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $groupOrders->links() }}
            </div>
        </div>
    </div>
@endsection
