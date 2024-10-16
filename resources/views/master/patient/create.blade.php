@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Patient') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.patient.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Patient') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.patient.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Patient') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.patient.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Patient') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.patient.index') }}" class="btn btn-secondary kt-margin-r-10">
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

                        <div class="row">
                            <div class="form-group col-md-6">
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

                            <div class="form-group col-md-6">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input id="phone" name="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror" required
                                    value="{{ old('phone') }}" autocomplete="off">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="dob">{{ __('Date of Birth') }}</label>
                                <input id="dob" name="dob" type="date"
                                    class="form-control @error('dob') is-invalid @enderror" required
                                    value="{{ old('dob') }}" autocomplete="off">

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender">{{ __('Gender') }}</label>
                                <select id="gender" name="gender"
                                    class="form-control kt_selectpicker @error('gender') is-invalid @enderror"
                                    data-live-search="true" title="{{ __('Choose') }} {{ __('Gender') }}" required>
                                    <option value="l" {{ old('gender') == 'l' ? 'selected' : '' }}>
                                        {{ __('Male') }}</option>
                                    <option value="p" {{ old('gender') == 'p' ? 'selected' : '' }}>
                                        {{ __('Female') }}</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                    required autocomplete="off">{{ old('address') }}</textarea>

                                @error('address')
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
    <script src="{{ asset('js/form/validation.js') }}"></script>
@endsection
