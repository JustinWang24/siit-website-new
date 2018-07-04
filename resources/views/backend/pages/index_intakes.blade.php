@extends('layouts.backend')
@section('content')
    <div id="">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    Intakes {{ trans('admin.mgr') }} ({{ $intakes->total() }})
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/intakes/add') }}"><i class="fa fa-plus"></i>&nbsp;New Intake</a>
            </div>
        </div>

        <div class="container">
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Scheduled/Seats</th>
                    <th>Online</th>
                    <th>Offline</th>
                    <th>Title/Code</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($intakes as $key=>$value)
                    @if($value->course)
                    <tr>
                        <td>
                            <a href="#" target="_blank">
                                {{ $value->course->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('/backend/intakes/items-manager/'.$value->id) }}">
                            @foreach($value->intakeItems as $item)
                                @if($item->seats && $item->scheduled)
                                    <p>{{ \App\Models\Catalog\IntakeItem::GetLanguageName($item->language_id).', '.$item->seats.', '.$item->scheduled->format('D d-M-y') }}</p>
                                @endif
                            @endforeach
                            </a>
                        </td>
                        <td>
                            {{ $value->online_date ? $value->online_date->format('D d/M/Y') : null }}
                        </td>
                        <td>
                            {{ $value->offline_date ? $value->offline_date->format('D d/M/Y') : null }}
                        </td>
                        <td>
                            {{ $value->title }} {{ $value->code ? '('.$value->code.')' : null }}
                        </td>
                        <td>{{ $value->account->name }}</td>
                        <td>
                            <a class="button is-small" href="{{ url('backend/intakes/edit/'.$value->id) }}">
                                <i class="fa fa-edit"></i>&nbsp;Edit
                            </a>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/intakes/delete/'.$value->id) }}">
                                <i class="fa fa-trash"></i>&nbsp;Del
                            </a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            {{ $intakes->links() }}
        </div>
    </div>
@endsection