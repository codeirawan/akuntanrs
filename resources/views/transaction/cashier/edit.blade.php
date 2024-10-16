@extends('layouts.app')

@section('title', __('Edit Account') . ' | ' . config('app.name'))

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('master.account.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Accounts') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('master.account.edit', $account->id) }}"
        class="kt-subheader__breadcrumbs-link">{{ $account->account_name }}</a>
@endsection

@section('content')
    <form action="{{ route('master.account.update', $account->id) }}" method="POST" class="kt-form">
        @csrf
        @method('PUT')

        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Edit Account') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('master.account.index') }}" class="btn btn-secondary kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span>{{ __('Back') }}</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check"></i>
                        <span>{{ __('Save') }}</span>
                    </button>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        @include('layouts.inc.alert')

                        <div class="form-group row">
                            <label for="account_name" class="col-sm-2 col-form-label">{{ __('Account Name') }}</label>
                            <div class="col-sm-10">
                                <input id="account_name" name="account_name" type="text"
                                    class="form-control @error('account_name') is-invalid @enderror"
                                    value="{{ old('account_name', $account->account_name) }}" required>

                                @error('account_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_code" class="col-sm-2 col-form-label">{{ __('Account Code') }}</label>
                            <div class="col-sm-10">
                                <input id="account_code" name="account_code" type="text"
                                    class="form-control @error('account_code') is-invalid @enderror"
                                    value="{{ old('account_code', $account->account_code) }}" required>

                                @error('account_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_type" class="col-sm-2 col-form-label">{{ __('Account Type') }}</label>
                            <div class="col-sm-10">
                                <select id="account_type" name="account_type"
                                    class="form-control @error('account_type') is-invalid @enderror">
                                    <option value="asset"
                                        {{ old('account_type', $account->account_type) == 'asset' ? 'selected' : '' }}>
                                        {{ __('Asset') }}</option>
                                    <option value="liability"
                                        {{ old('account_type', $account->account_type) == 'liability' ? 'selected' : '' }}>
                                        {{ __('Liability') }}</option>
                                    <option value="equity"
                                        {{ old('account_type', $account->account_type) == 'equity' ? 'selected' : '' }}>
                                        {{ __('Equity') }}</option>
                                    <option value="income"
                                        {{ old('account_type', $account->account_type) == 'income' ? 'selected' : '' }}>
                                        {{ __('Income') }}</option>
                                    <option value="expense"
                                        {{ old('account_type', $account->account_type) == 'expense' ? 'selected' : '' }}>
                                        {{ __('Expense') }}</option>
                                </select>

                                @error('account_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dc_type" class="col-sm-2 col-form-label">{{ __('Debit/Credit Type') }}</label>
                            <div class="col-sm-10">
                                <select id="dc_type" name="dc_type"
                                    class="form-control @error('dc_type') is-invalid @enderror">
                                    <option value="d"
                                        {{ old('dc_type', $account->dc_type) == 'd' ? 'selected' : '' }}>
                                        {{ __('Debit') }}</option>
                                    <option value="c"
                                        {{ old('dc_type', $account->dc_type) == 'c' ? 'selected' : '' }}>
                                        {{ __('Credit') }}</option>
                                </select>

                                @error('dc_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="opening_balance"
                                class="col-sm-2 col-form-label">{{ __('Opening Balance') }}</label>
                            <div class="col-sm-10">
                                <input id="opening_balance" name="opening_balance" type="text"
                                    class="form-control @error('opening_balance') is-invalid @enderror"
                                    value="{{ old('opening_balance', $account->opening_balance) }}" required>

                                @error('opening_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="opening_balance_date"
                                class="col-sm-2 col-form-label">{{ __('Opening Balance Date') }}</label>
                            <div class="col-sm-10">
                                <input id="opening_balance_date" name="opening_balance_date" type="date"
                                    class="form-control @error('opening_balance_date') is-invalid @enderror"
                                    value="{{ old('opening_balance_date', $account->opening_balance_date) }}" required>

                                @error('opening_balance_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_active">{{ __('Active') }}</label><br>
                            <span class="kt-switch kt-switch--icon kt-switch--primary kt-switch--outline">
                                <label class="mb-0">
                                    <input id="is_active" name="is_active" type="checkbox"
                                        {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                                    <span class="m-0"></span>
                                </label>
                            </span>
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
