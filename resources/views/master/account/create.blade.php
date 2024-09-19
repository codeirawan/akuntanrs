@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Account') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.account.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Account') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.account.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Account') }}</a>
@endsection

@section('content')
    <form class="kt-form" id="kt_form_1" action="{{ route('master.account.store') }}" method="POST">
        @csrf

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Account') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.account.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                                <label for="account_name">{{ __('Account Name') }}</label>
                                <input id="account_name" name="account_name" type="text"
                                    class="form-control @error('account_name') is-invalid @enderror" required
                                    value="{{ old('account_name') }}" autocomplete="off">

                                @error('account_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="account_code">{{ __('Account Code') }}</label>
                                <input id="account_code" name="account_code" type="text"
                                    class="form-control @error('account_code') is-invalid @enderror" required
                                    value="{{ old('account_code') }}" autocomplete="off">

                                @error('account_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="account_type">{{ __('Account Type') }}</label>
                                <select id="account_type" name="account_type"
                                    class="form-control kt_selectpicker @error('account_type') is-invalid @enderror"
                                    data-live-search="true" title="{{ __('Choose') }} {{ __('Account Type') }}" required>
                                    <option value="asset" {{ old('account_type') == 'asset' ? 'selected' : '' }}>
                                        {{ __('Asset') }}</option>
                                    <option value="liability" {{ old('account_type') == 'liability' ? 'selected' : '' }}>
                                        {{ __('Liability') }}</option>
                                    <option value="equity" {{ old('account_type') == 'equity' ? 'selected' : '' }}>
                                        {{ __('Equity') }}</option>
                                    <option value="income" {{ old('account_type') == 'income' ? 'selected' : '' }}>
                                        {{ __('Income') }}</option>
                                    <option value="expense" {{ old('account_type') == 'expense' ? 'selected' : '' }}>
                                        {{ __('Expense') }}</option>
                                </select>

                                @error('account_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="dc_type">{{ __('Debit/Credit Type') }}</label>
                                <select id="dc_type" name="dc_type"
                                    class="form-control kt_selectpicker @error('dc_type') is-invalid @enderror"
                                    data-live-search="true" title="{{ __('Choose') }} {{ __('Debit/Credit Type') }}" required>
                                    <option value="d" {{ old('dc_type') == 'd' ? 'selected' : '' }}>
                                        {{ __('Debit') }}</option>
                                    <option value="c" {{ old('dc_type') == 'c' ? 'selected' : '' }}>
                                        {{ __('Credit') }}</option>
                                </select>

                                @error('dc_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="opening_balance">{{ __('Opening Balance') }}</label>
                                <input id="opening_balance" name="opening_balance" type="number" step="0.01"
                                    class="form-control @error('opening_balance') is-invalid @enderror" required
                                    value="{{ old('opening_balance') }}" autocomplete="off">

                                @error('opening_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="opening_balance_date">{{ __('Opening Balance Date') }}</label>
                                <input id="opening_balance_date" name="opening_balance_date" type="date"
                                    class="form-control @error('opening_balance_date') is-invalid @enderror" required
                                    value="{{ old('opening_balance_date') }}" autocomplete="off">

                                @error('opening_balance_date')
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
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No results match') }}"
        });
    </script>
@endsection
