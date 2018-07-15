@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-10 pt-40 pl-20 pr-20" id="my-orders-manager-app">
        <br>
        <div class="content">
            <div class="columns">
                @include(_get_frontend_theme_path('customers.elements.dashboard.left_nav'))
                <div class="column">
                    @if(count($orders) == 0)
                        <p class="is-size-5 has-text-danger">
                            You don't have any order yet!
                        </p>
                    @else
                    <table class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Order #</th>
                            <th scope="col">Date</th>
                            <th scope="col">Course</th>
                            <th scope="col">Total(GST)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Offer Letter</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $key=>$value)
                            <tr>
                                <th scope="row">
                                    <a class="text-primary" href="{{ url('frontend/view_order/'.session('user_data.uuid').'/'.$value->uuid) }}">
                                        {{ $value->serial_number }}
                                    </a>
                                </th>
                                <td>{{ substr($value->created_at, 0, 11) }}</td>
                                <td>
                                    {{ count($value->orderItems) }}
                                </td>
                                <td>{{ config('system.CURRENCY'). ' '.number_format($value->getTotalFinal(),2) }}</td>
                                <td>{!! \App\Models\Utils\OrderStatus::GetName($value->status) !!}</td>
                                <td>
                                    @if($value->getStudentSignature())
                                        <a target="_blank" href="{{ url('catalog/course/get-offer-letter/'.$value->uuid) }}">Download</a>
                                    @endif
                                </td>
                                <td>
                                    @if(session('user_data.role') == \App\Models\Utils\UserGroup::$FINANCE_CONTROLLER && $value->status == \App\Models\Utils\OrderStatus::$PENDING)
                                        <div class="btn-group {{ $key>0&&$key==count($orders)-1 ? 'dropup' : null }}">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ url('frontend/view_order/'.session('user_data.uuid').'/'.$value->uuid) }}">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;View
                                                </a>
                                                <a class="dropdown-item need-confirm"
                                                   data-msg="Are you sure to approve this order (# {{$value->serial_number}})?"
                                                   href="{{ url('frontend/approve_order/'.session('user_data.uuid').'/'.$value->uuid) }}">
                                                    <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Approve
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" v-on:click="askWhy($event)"
                                                   data-msg="Are you sure to decline this order (# {{$value->serial_number}})?"
                                                   href="{{ url('frontend/decline_order/'.session('user_data.uuid').'/'.$value->uuid) }}">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Decline
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ url('frontend/view_order/'.session('user_data.uuid').'/'.$value->uuid) }}"
                                           class="button is-small">
                                            <span class="icon is-small">
                                              <i class="fas fa-pen-square"></i>
                                            </span>
                                            <span>Detail</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation example">
                    {{ $orders->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection