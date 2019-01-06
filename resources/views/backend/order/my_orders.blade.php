@extends('layouts.backend')
@section('content')
    <div class="container" id="my-orders-manager-app">
        <br>
            <div class="columns">
                <div class="column">
                    <h2 class="is-size-4">{{ trans('admin.menu.orders') }} {{ trans('admin.mgr') }} ({{ $orders->total() }})</h2>
                </div>
                <div class="column">
                    <el-form ref="form" label-width="80px">
                        <el-autocomplete
                            v-model="keyword"
                            icon="el-icon-search"
                            popper-class="order-search-auto-complete"
                            :select-when-unmatched="true"
                            :fetch-suggestions="querySearchAsync"
                            placeholder="Find an Orders: Order #"
                            @select="handleSelect"
                            :hide-loading="true"
                            :trigger-on-focus="false"
                            class="full-width"
                        ></el-autocomplete>
                    </el-form>
                </div>
            </div>
            <div class="container">
                <table class="table full-width is-hoverable">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Place Order</th>
                        <th scope="col">Date</th>
                        <th scope="col">Group</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Items</th>
                        <th scope="col">Total(GST)</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key=>$value)
                        <tr>
                            <th scope="row">{{ $value->serial_number }}</th>
                            <td>{{ $value->place_order_number }}</td>
                            <td>{{ substr($value->created_at, 0, 11) }}</td>
                            <td>
                                {{ \App\Models\Utils\UserGroup::RoleName($value->customer ? $value->customer->role : null) }}
                            </td>
                            <td>
                                <a href="{{ route('orders.list.by.student',['order'=>$value->uuid]) }}">{{$value->customer ? $value->customer->name : null }}</a>
                            </td>
                            <td>
                                <a href="#" v-on:click="showItems('{{$value->uuid}}')">
                                    <span class="badge badge-pill badge-light">{{ count($value->orderItems) }}</span>
                                </a>
                            </td>
                            <td>{{ config('system.CURRENCY'). ' '.number_format($value->total,2) }}</td>
                            <td>{!! \App\Models\Utils\OrderStatus::GetName($value->status) !!}</td>
                            <td>
                                <a href="{{ url('backend/orders/view/'.$value->id) }}" class="button is-primary is-small">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
    </div>
@endsection
