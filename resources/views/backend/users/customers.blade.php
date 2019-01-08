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
                    <th>Agents</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Passport</th>
                    <th>Cert</th>
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
                            <span class="{{ $value->status ? '':'has-text-danger' }}">{{ $value->name }}</span>
                        </td>
                        <td>
                            @foreach($value->dealers as $ds)
                                @php
                                    /** @var \App\Models\Dealer\DealerStudent $ds **/
                                @endphp
                                <p><a href="{{ route('admin.view.group.students',['group'=>$ds->group_id]) }}" target="_blank">{{ $ds->group->name }}</a></p>
                            @endforeach
                        </td>
                        <td>
                            <p>
                                <a href="mailto:{{ $value->email }}">{{ $value->email }}</a>
                            </p>
                            <p>
                                {{ $value->phone && strlen($value->phone) > 4 ? $value->phone : null }}
                            </p>
                        </td>
                        <td>
                            @if($value->address)
                            <p class="is-marginless">{{ $value->address }}</p>
                            <p class="is-marginless">{{ $value->city.' '.$value->postcode.', '.$value->state }}</p>
                            <p class="is-marginless">{{ $value->country }}</p>
                            @endif
                        </td>
                        <td>
                            @foreach(\App\Models\User\StudentProfile::$passportFields as $idx => $passportField)
                                @if($value->studentProfile && $value->studentProfile->$passportField)
                                    <p class="is-marginless">
                                    <a href="{{ route('download.file',['u'=>$value->uuid,'from'=>'sp','f'=>$passportField]) }}">Passport Page {{ $idx+1 }}</a>
                                    </p>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach(\App\Models\User\StudentProfile::$certsFields as $idx => $certsField)
                                @if($value->studentProfile)
                                    @if(is_array($value->studentProfile->$certsField))
                                        @foreach($value->studentProfile->$certsField as $key=>$link)
                                    <p class="is-marginless"><a href="{{ route('download.file',['u'=>$value->uuid,'from'=>'sp','f'=>$certsField,'index'=>$key]) }}">Certification {{ $idx+1 }} - {{ $key+1 }}</a></p>
                                        @endforeach
                                    @else
                                    <p class="is-marginless"><a href="{{ route('download.file',['u'=>$value->uuid,'from'=>'sp','f'=>$certsField]) }}">Certification {{ $idx+1 }}</a></p>
                                    @endif
                                @endif
                            @endforeach
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