@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Service') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('master.service.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Service') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('master.service.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }}
        {{ __('Service') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.service.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Service') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.service.index') }}" class="btn btn-secondary kt-margin-r-10">
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

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="service_type">{{ __('Service Type') }}</label>
                                <select id="service_type" name="service_type"
                                    class="form-control @error('service_type') is-invalid @enderror" required>
                                    <option value="1" {{ old('service_type') == 1 ? 'selected' : '' }}>
                                        {{ __('Consultation') }}</option>
                                    <option value="2" {{ old('service_type') == 2 ? 'selected' : '' }}>
                                        {{ __('Surgery') }}</option>
                                    <option value="3" {{ old('service_type') == 3 ? 'selected' : '' }}>
                                        {{ __('Diagnostic') }}</option>
                                    <option value="4" {{ old('service_type') == 4 ? 'selected' : '' }}>
                                        {{ __('Inpatient') }}</option>
                                    <option value="5" {{ old('service_type') == 5 ? 'selected' : '' }}>
                                        {{ __('Outpatient') }}</option>
                                </select>

                                @error('service_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="service_code">{{ __('Service Code') }}</label>
                                <input id="service_code" name="service_code" type="text"
                                    class="form-control @error('service_code') is-invalid @enderror" required
                                    value="{{ old('service_code') }}" autocomplete="off">

                                @error('service_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="service_name">{{ __('Service Name') }}</label>
                                <input id="service_name" name="service_name" type="text"
                                    class="form-control @error('service_name') is-invalid @enderror" required
                                    value="{{ old('service_name') }}" autocomplete="off">

                                @error('service_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="price">{{ __('Price') }}</label>
                                <input id="price" name="price" type="number" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror" required
                                    value="{{ old('price') }}" autocomplete="off">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
