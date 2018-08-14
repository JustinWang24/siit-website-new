@extends('layouts.backend')
@section('content')
    <div id="dealer-manager-app">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    {{ trans('admin.menu.groups') }} {{ trans('admin.mgr') }}
                </h2>
            </div>
            <div class="column">
                <el-autocomplete
                    v-model="keyword"
                    style="width: 400px;"
                    :fetch-suggestions="querySearchAsync"
                    placeholder="Find a dealer: Name / Code"
                    @select="handleSelect"
                    :hide-loading="true"
                    :trigger-on-focus="false"
                >
                    <template slot-scope="{ item }">
                        <p class="name">@{{ item.value }} (@{{ item.address }})</p>
                    </template>

                </el-autocomplete>
                <a class="button is-primary pull-right" href="{{ url('/backend/groups/add') }}"><i class="fa fa-plus"></i>&nbsp;{{ trans('admin.new.groups') }}</a>
            </div>
        </div>

        <div class="container">
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th>ID Code</th>
                    <th>Business name</th>
                    <th>Contact</th>
                    <th>Other</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $key=>$value)
                    <tr>
                        <td>
                            {!! $value->group_code !!}
                        </td>
                        <td>
                            <p>{{ $value->name }}</p>
                            <p>{{ $value->address }}</p>
                        </td>
                        <td>
                            <p>{{ $value->contact_person }}</p>
                            <p><a href="mailto:{{ $value->email }}">{!! $value->email !!}</a></p>
                            <p>{{ $value->phone }}</p>
                        </td>
                        <td>
                            <p>{{ $value->extra }}</p>
                            <p>Discount: {{ $value->discount_rate }}%</p>
                            <p>Commission: {{ $value->comission }}%</p>
                        </td>
                        <td>
                            <a class="button is-small" href="{{ url('backend/groups/edit/'.$value->id) }}">
                                <i class="fa fa-edit"></i>&nbsp;Edit
                            </a>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/groups/delete/'.$value->id) }}">
                                <i class="fa fa-trash"></i>&nbsp;Del
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $groups->links() }}
        </div>
    </div>
@endsection