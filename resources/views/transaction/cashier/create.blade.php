@extends('layouts.app')

@section('title', __('Create Cashier Transaction'))

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('transaction.cashier.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Cashier') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('transaction.cashier.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Cashier Transaction') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Create Cashier Transaction') }}
                </h3>
            </div>
        </div>
        <form class="kt-form" method="POST" action="{{ route('transaction.cashier.store') }}">
            @csrf
            <div class="kt-portlet" id="kt_page_portlet">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('User') }}</h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Voucher') }}</label>
                    <div class="col-lg-6">
                        <input type="text" name="voucher" class="form-control @error('voucher') is-invalid @enderror" value="{{ old('voucher') }}" placeholder="{{ __('Enter voucher') }}" required>
                        @error('voucher')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Date') }}</label>
                    <div class="col-lg-6">
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Account') }}</label>
                    <div class="col-lg-6">
                        <select name="account_id" class="form-control @error('account_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select account') }}</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Unit') }}</label>
                    <div class="col-lg-6">
                        <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select unit') }}</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Service') }}</label>
                    <div class="col-lg-6">
                        <select name="service_id" class="form-control @error('service_id') is-invalid @enderror">
                            <option value="">{{ __('Select service') }}</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Patient') }}</label>
                    <div class="col-lg-6">
                        <select name="patient_id" class="form-control @error('patient_id') is-invalid @enderror">
                            <option value="">{{ __('Select patient') }}</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Unregistered Patient') }}</label>
                    <div class="col-lg-6">
                        <input type="text" name="unregistered_patient" class="form-control @error('unregistered_patient') is-invalid @enderror" value="{{ old('unregistered_patient') }}" placeholder="{{ __('Enter unregistered patient') }}">
                        @error('unregistered_patient')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Service Type') }}</label>
                    <div class="col-lg-6">
                        <select name="service_type" class="form-control @error('service_type') is-invalid @enderror" required>
                            <option value="">{{ __('Select service type') }}</option>
                            <option value="1" {{ old('service_type') == 1 ? 'selected' : '' }}>{{ __('Inpatient') }}</option>
                            <option value="2" {{ old('service_type') == 2 ? 'selected' : '' }}>{{ __('Outpatient') }}</option>
                            <option value="3" {{ old('service_type') == 3 ? 'selected' : '' }}>{{ __('Medication') }}</option>
                        </select>
                        @error('service_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Transaction Type') }}</label>
                    <div class="col-lg-6">
                        <select name="transaction_type" class="form-control @error('transaction_type') is-invalid @enderror" required>
                            <option value="">{{ __('Select transaction type') }}</option>
                            <option value="1" {{ old('transaction_type') == 1 ? 'selected' : '' }}>{{ __('Cash') }}</option>
                            <option value="2" {{ old('transaction_type') == 2 ? 'selected' : '' }}>{{ __('Non Cash') }}</option>
                            <option value="3" {{ old('transaction_type') == 3 ? 'selected' : '' }}>{{ __('Petty Cash') }}</option>
                            <option value="4" {{ old('transaction_type') == 4 ? 'selected' : '' }}>{{ __('Receivables') }}</option>
                        </select>
                        @error('transaction_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Amount') }}</label>
                    <div class="col-lg-6">
                        <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" placeholder="{{ __('Enter amount') }}" required>
                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Payment Status') }}</label>
                    <div class="col-lg-6">
                        <select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
                            <option value="">{{ __('Select payment status') }}</option>
                            <option value="1" {{ old('payment_status') == 1 ? 'selected' : '' }}>{{ __('Paid') }}</option>
                            <option value="2" {{ old('payment_status') == 2 ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                            <option value="3" {{ old('payment_status') == 3 ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        </select>
                        @error('payment_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Description') }}</label>
                    <div class="col-lg-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Enter description') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('transaction.cashier.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
