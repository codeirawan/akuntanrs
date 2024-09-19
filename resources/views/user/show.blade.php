@extends('layouts.app')

@section('title')
    {{ __('User Details') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('user.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('User') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('user.show', $user->id) }}"
        class="kt-subheader__breadcrumbs-link">{{ $user->email }}</a>
@endsection

@section('content')
    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('User Details') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    <i class="la la-arrow-left"></i>
                    <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                </a>
                @if (Laratrust::isAbleTo('update-user'))
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary kt-margin-l-10">
                        <i class="la la-edit"></i>
                        <span class="kt-hidden-mobile">{{ __('Edit') }}</span>
                    </a>
                @endif
                @if (Laratrust::isAbleTo('delete-user'))
                    <a href="#" data-href="{{ route('user.destroy', $user->id) }}"
                        class="btn btn-danger kt-margin-l-10" title="{{ __('Delete') }}" data-toggle="modal"
                        data-target="#modal-delete" data-key="{{ $user->email }}">
                        <i class="la la-trash"></i>
                        <span class="kt-hidden-mobile">{{ __('Delete') }}</span>
                    </a>
                @endif
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section kt-section--first">
                <div class="kt-section__body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{ __('Name') }}</label>
                            <input type="text" class="form-control" disabled value="{{ $user->name }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Email</label>
                            <input type="email" class="form-control" disabled value="{{ $user->email }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>ID</label>
                            <input type="text" class="form-control" disabled value="{{ $user->nik }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ __('Role') }}</label>
                            <input type="text" class="form-control" disabled value="{{ $role }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Active') }}</label><br>
                        <span class="kt-switch kt-switch--icon kt-switch--primary kt-switch--outline">
                            <label class="mb-0">
                                <input type="checkbox" {{ $user->active ? 'checked' : '' }} disabled>
                                <span class="m-0"></span>
                            </label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.inc.modal.delete', ['object' => 'user'])
@endsection
