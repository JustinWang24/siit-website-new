@extends('layouts.backend')
@section('content')
    <div class="content" id="student-manager-app">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    Students Management ({{ $dealer->name }})<span id="dealer-id" data-content="{{ $dealer->id }}"></span>
                </h2>
            </div>
            <div class="column">
                <el-autocomplete
                    v-model="keyword"
                    :fetch-suggestions="querySearchAsync"
                    placeholder="Find a student: Name"
                    @select="handleSelect"
                    :hide-loading="true"
                    :trigger-on-focus="false"
                    class="full-width"
                >
                    <template slot-scope="{ item }">
                        <p class="name">@{{ item.value }} (@{{ item.address }})</p>
                    </template>
                </el-autocomplete>
            </div>
        </div>

        <div class="content">
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ds as $key=>$d)
                    @php
                        /** @var \App\Models\Dealer\DealerStudent $d **/
                        $value = $d->student;
                    @endphp
                    <tr>
                        <td>
                            {{ $value->name }}
                        </td>
                        <td>
                            <a href="mailto:{{ $value->email }}">{{ $value->email }}</a>
                        </td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->address ? $value->addressText() : null }}</td>
                        <td>
                            {{ $value->status ? 'Active':'Suspend' }}
                        </td>
                        <td>
                            <a class="button is-small" href="{{ url('backend/customers/edit/'.$value->id) }}">
                                <i class="fa fa-edit"></i>&nbsp;Edit
                            </a>
                            <a class="button is-small" href="{{ url('backend/update-password?customer_id='.$value->uuid) }}">
                                <i class="fa fa-key"></i>&nbsp;Change Password
                            </a>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/customers/delete/'.$value->uuid) }}">
                                <i class="fa fa-trash"></i>&nbsp;Del
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $ds->links() }}
        </div>
    </div>
@endsection