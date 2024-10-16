@extends('layouts.app')

@section('title')
    {{ __('Edit') }} {{ __('Unit') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.unit.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Unit') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.unit.edit', $unit->id) }}"
        class="kt-subheader__breadcrumbs-link">{{ $unit->name }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.unit.update', $unit->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Edit') }} {{ __('Unit') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.unit.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                            <div class="form-group col-md-12">
                                <label for="unit_name">{{ __('Unit Name') }}</label>
                                <input id="unit_name" name="unit_name" type="text"
                                    class="form-control @error('unit_name') is-invalid @enderror" required
                                    value="{{ old('unit_name', $unit->unit_name) }}" autocomplete="off">

                                @error('unit_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- <div class="form-group col-sm-6">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                    rows="3">{{ old('description', $unit->description) }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
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
