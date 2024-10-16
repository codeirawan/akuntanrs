@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Item') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.item.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Item') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.item.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Item') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.item.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Item') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.item.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                            <label for="code">{{ __('Code') }}</label>
                            <input id="code" name="code" type="text"
                                class="form-control @error('code') is-invalid @enderror" required
                                value="{{ old('code') }}" autocomplete="off">

                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

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
                            <label for="unit">{{ __('Unit') }}</label>
                            <input id="unit" name="unit" type="text"
                                class="form-control @error('unit') is-invalid @enderror" required
                                value="{{ old('unit') }}" autocomplete="off">

                            @error('unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
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

                        <div class="form-group">
                            <label for="category">{{ __('Category') }}</label>
                            <select id="category" name="category"
                                class="form-control @error('category') is-invalid @enderror" required>
                                <option value="1" {{ old('category') == 1 ? 'selected' : '' }}>{{ __('Pharmacy') }}
                                </option>
                                <option value="2" {{ old('category') == 2 ? 'selected' : '' }}>{{ __('Logistic') }}
                                </option>
                                <option value="3" {{ old('category') == 3 ? 'selected' : '' }}>{{ __('General') }}
                                </option>
                            </select>

                            @error('category')
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
    <script src="{{ asset('js/form/validation.js') }}"></script>
@endsection
