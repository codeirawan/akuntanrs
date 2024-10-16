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
                                <label for="sub_account_name">{{ __('Sub Account Name') }}</label>
                                <input id="sub_account_name" name="sub_account_name" type="text"
                                    class="form-control @error('sub_account_name') is-invalid @enderror" required
                                    value="{{ old('sub_account_name') }}" autocomplete="off">

                                @error('sub_account_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="account_type">{{ __('Account Type') }}</label>
                                <select id="account_type" name="account_type"
                                    class="form-control kt_selectpicker @error('account_type') is-invalid @enderror"
                                    data-live-search="true" title="{{ __('Choose') }} {{ __('Account Type') }}" required>
                                    <option value="1" {{ old('account_type') == '1' ? 'selected' : '' }}>
                                        {{ __('Liquid Asset') }}</option>
                                    <option value="2" {{ old('account_type') == '2' ? 'selected' : '' }}>
                                        {{ __('Fixed Asset') }}</option>
                                    <option value="3" {{ old('account_type') == '3' ? 'selected' : '' }}>
                                        {{ __('Liability') }}</option>
                                    <option value="4" {{ old('account_type') == '4' ? 'selected' : '' }}>
                                        {{ __('Equity') }}</option>
                                    <option value="5" {{ old('account_type') == '5' ? 'selected' : '' }}>
                                        {{ __('Income') }}</option>
                                    <option value="6" {{ old('account_type') == '6' ? 'selected' : '' }}>
                                        {{ __('Expense') }}</option>
                                    <option value="7" {{ old('account_type') == '7' ? 'selected' : '' }}>
                                        {{ __('Other') }}</option>
                                </select>

                                @error('account_type')
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
                                    class="form-control @error('opening_balance') is-invalid @enderror"
                                    value="{{ old('opening_balance') }}" autocomplete="off">

                                @error('opening_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="opening_balance_date">{{ __('Opening Balance Date') }}</label>
                                <input id="opening_balance_date" name="opening_balance_date" type="text"
                                    placeholder="{{ __('Select') }} {{ __('Date') }}"
                                    class="form-control @error('opening_balance_date') is-invalid @enderror"
                                    value="{{ old('opening_balance_date') }}" autocomplete="off" readonly>

                                @error('opening_balance_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="is_debit">{{ __('Is Debit') }}</label><br>
                                <span class="kt-switch kt-switch--icon kt-switch--primary kt-switch--outline">
                                    <label class="mb-0">
                                        <input id="is_debit" name="is_debit" type="checkbox"
                                            {{ old('is_debit') ? 'checked' : '' }} value="1"
                                            onchange="this.value = this.checked ? 1 : 0;">
                                        <span class="m-0"></span>
                                    </label>
                                </span>
                                @error('is_debit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="is_credit">{{ __('Is Credit') }}</label><br>
                                <span class="kt-switch kt-switch--icon kt-switch--primary kt-switch--outline">
                                    <label class="mb-0">
                                        <input id="is_credit" name="is_credit" type="checkbox"
                                            {{ old('is_credit') ? 'checked' : '' }} value="1"
                                            onchange="this.value = this.checked ? 1 : 0;">
                                        <span class="m-0"></span>
                                    </label>
                                </span>
                                @error('is_credit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="bs_flag">{{ __('Balance Sheet Flag') }}</label><br>
                                <span class="kt-switch kt-switch--icon kt-switch--primary kt-switch--outline">
                                    <label class="mb-0">
                                        <input id="bs_flag" name="bs_flag" type="checkbox"
                                            {{ old('bs_flag') ? 'checked' : '' }} value="1"
                                            onchange="this.value = this.checked ? 1 : 0;">
                                        <span class="m-0"></span>
                                    </label>
                                </span>
                                @error('bs_flag')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="pl_flag">{{ __('Profit/Loss Flag') }}</label><br>
                                <span class="kt-switch kt-switch--icon kt-switch--primary kt-switch--outline">
                                    <label class="mb-0">
                                        <input id="pl_flag" name="pl_flag" type="checkbox"
                                            {{ old('pl_flag') ? 'checked' : '' }} value="1"
                                            onchange="this.value = this.checked ? 1 : 0;">
                                        <span class="m-0"></span>
                                    </label>
                                </span>
                                @error('pl_flag')
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
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No results match') }}"
        });
    </script>
    <script>
        $('#opening_balance_date').datepicker({
            autoclose: true,
            clearBtn: true,
            disableTouchKeyboard: true,
            format: "dd-mm-yyyy",
            language: "{{ config('app.locale') }}",
            startDate: "0d",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
            todayBtn: "linked",
            todayHighlight: true
        });
    </script>
@endsection
