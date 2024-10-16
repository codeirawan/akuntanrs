@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Fiscal Year') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.fiscal-year.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Fiscal Year') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.fiscal-year.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Fiscal Year') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.fiscal-year.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Fiscal Year') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.fiscal-year.index') }}" class="btn btn-secondary kt-margin-r-10">
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

                        {{-- <div class="row">
                            <div class="form-group col-md-6">
                                <label for="code">{{ __('Fiscal Year Code') }}</label>
                                <input id="code" name="code" type="text"
                                    class="form-control @error('code') is-invalid @enderror" required
                                    value="{{ old('code') }}" autocomplete="off">

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="name">{{ __('Fiscal Year Name') }}</label>
                                <input id="name" name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" required
                                    value="{{ old('name') }}" autocomplete="off">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="start_date">{{ __('Start Date') }}</label>
                                <input id="start_date" name="start_date" type="date"
                                    class="form-control @error('start_date') is-invalid @enderror" required
                                    value="{{ old('start_date') }}" autocomplete="off">

                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="end_date">{{ __('End Date') }}</label>
                                <input id="end_date" name="end_date" type="date"
                                    class="form-control @error('end_date') is-invalid @enderror" required
                                    value="{{ old('end_date') }}" autocomplete="off">

                                @error('end_date')
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
