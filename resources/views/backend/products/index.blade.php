@extends('layouts.backend')

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
                    <div class="column">
                        <a class="button is-primary pull-right ml-10" href="{{ url('/backend/products/add') }}">
                            <i class="fa fa-plus"></i>&nbsp;{{ trans('admin.new.products') }}
                        </a>
                    </div>
                </div>
                <table class="table full-width is-hoverable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Categories</th>
                        <th>Campus</th>
                        <th>Price</th>
                        <th>Attribute Set</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key=>$value)
                        <tr class="align-middle">
                            <td><img class="img-thumbnail" width="80" src="{{ $value->getProductDefaultImageUrl() }}" alt=""></td>
                            <td>
                                <p>{{ $value->name }}</p>
                                <p>{{ $value->name_cn }}</p>
                            </td>
                            <td>
                                {{ \App\Models\Utils\ProductType::getTypeName($value->type) }}
                            </td>
                            <td>
                                <?php
                                    $cats = $value->categories();
                                    if($cats){
                                        foreach ($cats as $cat) {
                                            ?>
                                <span class="badge badge-light">{{ $cat->name }}</span>
                                            <?php
                                        }
                                    }
                                ?>
                            </td>
                            <td>{{ $value->brand }}</td>
                            <td>
                                <p>${{ $value->default_price }}</p>
                                <p class="has-text-danger">${{ $value->special_price }}</p>
                            </td>
                            <td>{{ $value->attribute_set_id==\App\Models\Utils\ProductType::$BASIC_PRODUCT_ATTRIBUTE_SET ? 'General' : $value->attributeSet->name }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="button is-small" href="{{ url('backend/products/edit/'.$value->id) }}" title="Edit Product">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <a class="button is-small" href="{{ url('backend/products/related/'.$value->id) }}" title="Related Products">
                                        <i class="fa fa-link" aria-hidden="true"></i>
                                    </a>
                                    <a class="button is-danger is-small btn-delete" href="{{ url('backend/products/delete/'.$value->uuid) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
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
