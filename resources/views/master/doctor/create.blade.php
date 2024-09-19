@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Doctor') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.doctor.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Doctor') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.doctor.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Doctor') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.doctor.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Doctor') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.doctor.index') }}" class="btn btn-secondary kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check"></i>
                        <span class="kt-hidden-mobile">{{ __('Save') }}</span>
                    </button>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        @include('layouts.inc.alert')

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" required
                                value="{{ old('name') }}" autocomplete="off">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="specialization">{{ __('Specialization') }}</label>
                            <select id="specialization" name="specialization"
                                class="form-control kt_selectpicker @error('specialization') is-invalid @enderror"
                                data-live-search="true" title="{{ __('Choose') }} {{ __('Specialization') }}" required>
                                @foreach ($specialties as $specialty)
                                    <option value="{{ $specialty->id }}"
                                        {{ old('specialization') == $specialty->id ? 'selected' : '' }}>
                                        {{ $specialty->name }}</option>
                                @endforeach
                            </select>

                            @error('specialization')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
@endsection
