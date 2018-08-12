@extends('layouts.backend')

@section('content')
    <div class="content">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    Dealer {{ empty($group->name) ? null : ':'.$group->name }}
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/groups') }}"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
            </div>
        </div>
    </div>

    <div class="content">
        <form class="form" method="POST" action="{{ url('backend/groups/save') }}">
                @csrf
            <input type="hidden" name="id" value="{{ $group->id }}">

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Dealer Name</label>
                        <div class="control">
                            <input type="text" class="input{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $group->name }}" required autofocus placeholder="经销商名称: Required">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">状态</label>
                        <div class="control">
                            <div class="select full-width">
                                <select class="full-width" name="status">
                                    <option value="{{ \App\Models\Group::STATUS_ACTIVE }}" {{ $group->status===\App\Models\Group::STATUS_ACTIVE ? 'selected' : null }}>上线</option>
                                    <option value="{{ \App\Models\Group::STATUS_DISABLE }}" {{ $group->status===\App\Models\Group::STATUS_DISABLE ? 'selected' : null }}>暂停</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">经销商识别码</label>
                        <div class="control">
                            <input type="text" class="input{{ $errors->has('group_code') ? ' is-invalid' : '' }}" name="group_code" value="{{ $group->group_code }}" required placeholder="Required: 经销商唯一识别码">
                            @if ($errors->has('group_code'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('group_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input type="text" class="input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ $group->password }}" required placeholder="Required: 登录密码">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input type="email" class="input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $group->email }}" required placeholder="Required: 电子邮件">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Contact Person</label>
                        <div class="control">
                            <input type="text" class="input{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" value="{{ $group->contact_person }}" placeholder="Contact Person">
                            @if ($errors->has('contact_person'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('contact_person') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Phone</label>
                        <div class="control">
                            <input type="text" class="input{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $group->phone }}" placeholder="联系电话">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Address</label>
                        <div class="control">
                            <div class=" full-width">
                                <input type="text" class="input{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $group->address }}" placeholder="Required: 公司地址">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Extra Info</label>
                <div class="control">
                    <textarea class="textarea" name="extra" placeholder="Optional: 其他信息">{{ $group->extra }}</textarea>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="control">
                    <button type="submit" class="button is-link">
                        <i class="fa fa-upload"></i>&nbsp;Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
