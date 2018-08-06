@extends('layouts.dealer_portal')
@section('content')
    <div class="container">
        <br>
        <div class="content">
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <h2 class="is-size-4">
                            {{ trans('admin.menu.products') }} {{ trans('admin.mgr') }} ({{ $products->total() }})
                        </h2>
                    </div>
                    <div class="column"></div>
                </div>
                <table class="table full-width is-hoverable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Campus</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key=>$value)
                        <tr class="align-middle">
                            <td>{{ $key+1 }}</td>
                            <td>
                                <a target="_blank" href="{{ url('catalog/product/'.$value->uri) }}">
                                    <p>{{ $value->name }} - {{ $value->name_cn }}</p>
                                </a>
                            </td>
                            <td>{{ $value->brand }}</td>
                            <td>
                                <p>${{ $value->default_price }}&nbsp;/&nbsp;<span class="has-text-danger">${{ $value->special_price }}</span></p>
                            </td>
                            <td>
                                <button class="button is-small copy-txt-btn" title="Copy"
                                        data-clipboard-text="{{ url('catalog/product/'.$value->uri) }}?agent={{ session('group_data.group_code') }}">
                                    <i class="fas fa-copy"></i>&nbsp;Copy
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
