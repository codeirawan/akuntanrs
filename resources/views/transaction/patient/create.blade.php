@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Patient') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('patient.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Patient') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('patient.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Patient') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('patient.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Patient') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('patient.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                                <label for="nik">{{ __('NIK') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input id="nik" name="nik" type="number"
                                        class="form-control @error('nik') is-invalid @enderror" required
                                        value="{{ old('nik') }}" autocomplete="off">

                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="dob">{{ __('Date of Birth') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input id="dob" name="dob" type="date"
                                        class="form-control @error('dob') is-invalid @enderror" required
                                        value="{{ old('dob') }}" autocomplete="off">

                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender">{{ __('Gender') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    </div>
                                    <select id="gender" name="gender"
                                        class="form-control kt_selectpicker @error('gender') is-invalid @enderror"
                                        data-live-search="true" title="{{ __('Choose') }} {{ __('Gender') }}" required>
                                        <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>
                                            {{ __('Male') }}</option>
                                        <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>
                                            {{ __('Female') }}</option>
                                    </select>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="phone">{{ __('Phone') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input id="phone" name="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}" autocomplete="off">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">{{ __('Email') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input id="email" name="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" autocomplete="off">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="insurance_name">{{ __('Insurance Provider') }}</label>
                                <input id="insurance_name" name="insurance_name" type="text"
                                    class="form-control @error('insurance_name') is-invalid @enderror"
                                    value="{{ old('insurance_name') }}" autocomplete="off">

                                @error('insurance_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="insurance_no">{{ __('Insurance Number') }}</label>
                                <input id="insurance_no" name="insurance_no" type="number"
                                    class="form-control @error('insurance_no') is-invalid @enderror"
                                    value="{{ old('insurance_no') }}" autocomplete="off">

                                @error('insurance_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                    autocomplete="off">{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea id="note" name="note" rows="3" class="form-control @error('note') is-invalid @enderror"
                                    autocomplete="off">{{ old('note') }}</textarea>

                                @error('note')
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
