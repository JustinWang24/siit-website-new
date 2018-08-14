@extends('layouts.backend')
@section('content')
    <div class="content">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    Students Manager
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/customers/add') }}"><i class="fa fa-plus"></i>&nbsp;{{ trans('admin.new.customers') }}</a>
            </div>
        </div>

        <div class="content">
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Dealer</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $key=>$value)
                    @php
                        /** @var \App\User $value **/
                    @endphp
                    <tr>
                        <td>
                            {{ $value->name }}
                        </td>
                        <td>
                            <a href="mailto:{{ $value->email }}">{{ $value->email }}</a>
                        </td>
                        <td>{{ $value->phone }}</td>
                        <td>
                            @foreach($value->dealers as $ds)
                            @php
                                /** @var \App\Models\Dealer\DealerStudent $ds **/
                            @endphp
                            <p><a href="{{ route('admin.view.group.students',['group'=>$ds->group_id]) }}" target="_blank">{{ $ds->group->name }}</a></p>
                            @endforeach
                        </td>
                        <td>{{ $value->address ? $value->addressText() : null }}</td>
                        <td>
                            {{ $value->status ? 'Active':'Suspend' }}
                        </td>
                        <td>
                            <a class="button is-small" href="{{ url('backend/customers/edit/'.$value->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="button is-small" href="{{ url('backend/update-password?customer_id='.$value->uuid) }}">
                                <i class="fa fa-key"></i>&nbsp;Password
                            </a>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/customers/delete/'.$value->uuid) }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>
@endsection