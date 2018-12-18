@extends('layouts.backend')
@section('content')
    <div class="content">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    {{ trans('admin.menu.voucher') }} {{ trans('admin.mgr') }}
                </h2>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <table class="table full-width is-hoverable">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vouchers as $key=>$value)
                        <tr>
                            <td>
                                {{ $value->code }}
                            </td>
                            <td>
                                {{ $value->is_percent ? null:'$' }}{{ $value->discount_value }}{{ $value->is_percent ? '%':null }}
                            </td>
                            <td>{{ $value->used ? 'Redeemed':null }}</td>
                            <td>
                                <a class="button is-danger is-small btn-delete" href="{{ url('backend/users/delete/'.$value->uuid) }}">
                                    <i class="fa fa-trash"></i>&nbsp;Del
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $vouchers->links() }}
            </div>
            <div class="column">
                <div class="content">
                <h3 class="has-text-centered">Vouchers Generator</h3>
                <hr>
                <form action="{{ route('admin.voucher.generator') }}" method="post">
                    @csrf
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Voucher Type</label>
                            <div class="control">
                                <div class="select">
                                    <select name="bulk[type]">
                                        <option value="1">General</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Discount Type</label>
                            <div class="control">
                                <div class="select">
                                    <select name="bulk[is_percent]">
                                        <option value="1">Percentage</option>
                                        <option value="0">
                                            Exact Value
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Value</label>
                            <div class="control">
                                <input name="bulk[discount_value]" class="input" type="number" placeholder="Value" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Amount</label>
                            <div class="control">
                                <input name="amount" class="input" type="number" placeholder="Amount" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Commence</label>
                            <div class="control">
                                <input name="bulk[commence]" class="input" type="date" placeholder="Commence Date">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Expired At</label>
                            <div class="control">
                                <input name="bulk[expired_at]" class="input" type="date" placeholder="Expired At">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Submit</button>
                    </div>
                    <div class="control">
                        <button class="button is-text">Cancel</button>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection