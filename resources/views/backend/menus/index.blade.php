@extends('layouts.backend')
@section('content')
    <div id="">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    {{ trans('admin.menu.menus') }} {{ trans('admin.mgr') }}
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/menus/add') }}"><i class="fa fa-plus"></i>&nbsp;{{ trans('admin.new.menu') }}</a>
            </div>
        </div>

        <div class="container">
            <table class="table full-width is-hoverable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>菜单中文名</th>
                    <th>Position</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menus as $key=>$value)
                    <tr>
                        <td>
                            {{ $key+1 }}:&nbsp;<a href="{{ $value->getMenuUrl() }}" target="_blank">{{ $value->name }}</a>
                        </td>
                        <td>
                            {{ $value->name_cn }}
                        </td>
                        <td>{{ $value->position }}</td>
                        <td>
                            {{ $value->link_type == \App\Models\Menu::TYPE_STATIC_CONTENT ? 'Static' : 'Dynamic' }}
                        </td>
                        <td>{{ $value->active ? 'Published' : 'Unpublished' }}</td>
                        <td>
                            <a class="button is-small" href="{{ url('backend/menus/edit/'.$value->id) }}">
                                <i class="fa fa-edit"></i>&nbsp;Edit
                            </a>
                            <a class="button is-danger is-small btn-delete" href="{{ url('backend/menus/delete/'.$value->id) }}">
                                <i class="fa fa-trash"></i>&nbsp;Del
                            </a>
                        </td>
                    </tr>
                    @if(count($value->children)>0)
                        @foreach($value->children as $idxFirst=>$subFirst)
                        <tr>
                            <td>
                                <p class="pl-20">{{ $key+1 }}-{{ $idxFirst+1 }}: <a href="{{ $subFirst->getMenuUrl() }}" target="_blank">{{ $subFirst->name }}</a></p>
                            </td>
                            <td>
                                {{ $subFirst->name_cn }}
                            </td>
                            <td>{{ $subFirst->position }}</td>
                            <td>
                                {{ $subFirst->link_type == \App\Models\Menu::TYPE_STATIC_CONTENT ? 'Static' : 'Dynamic' }}
                            </td>
                            <td>{{ $subFirst->active ? 'Published' : 'Unpublished' }}</td>
                            <td>
                                <a class="button is-small" href="{{ url('backend/menus/edit/'.$subFirst->id) }}">
                                    <i class="fa fa-edit"></i>&nbsp;Edit
                                </a>
                                <a class="button is-danger is-small btn-delete" href="{{ url('backend/menus/delete/'.$subFirst->id) }}">
                                    <i class="fa fa-trash"></i>&nbsp;Del
                                </a>
                            </td>
                        </tr>
                        @if(count($value->children)>0)
                            @foreach($subFirst->children as $idxSecond=>$subSecond)
                                <tr>
                                    <td>
                                        <p class="pl-20 ml-20">{{ $key+1 }}-{{ $idxFirst+1 }}-{{ $idxSecond+1 }}: <a href="{{ $subSecond->getMenuUrl() }}" target="_blank">{{ $subSecond->name }}</a></p>
                                    </td>
                                    <td>
                                        {{ $subSecond->name_cn }}
                                    </td>
                                    <td>{{ $subSecond->position }}</td>
                                    <td>
                                        {{ $subSecond->link_type == \App\Models\Menu::TYPE_STATIC_CONTENT ? 'Static' : 'Dynamic' }}
                                    </td>
                                    <td>{{ $subSecond->active ? 'Published' : 'Unpublished' }}</td>
                                    <td>
                                        <a class="button is-small" href="{{ url('backend/menus/edit/'.$subSecond->id) }}">
                                            <i class="fa fa-edit"></i>&nbsp;Edit
                                        </a>
                                        <a class="button is-danger is-small btn-delete" href="{{ url('backend/menus/delete/'.$subSecond->id) }}">
                                            <i class="fa fa-trash"></i>&nbsp;Del
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection