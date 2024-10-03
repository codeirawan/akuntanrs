@extends('layouts.app')

@section('title', __('Create Cashier Transaction'))

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('transaction.cashier.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Cashier') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('transaction.cashier.create') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Cashier Transaction') }}</a>
@endsection

@section('content')
    <form class="kt-form" method="POST" action="{{ route('transaction.cashier.store') }}">
        @csrf
        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Transaction ID : #CS-20240920-YJKL</h3>
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

                <!-- Group 1: Account and Unit Information -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Account and Unit Information') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{ __('Account') }}</label>
                                <select name="account_id" class="form-control @error('account_id') is-invalid @enderror" required>
                                    <option value="">{{ __('Select account') }}</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('account_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Unit') }}</label>
                                <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                                    <option value="">{{ __('Select unit') }}</option>
                                    @foreach ($units as $unit)
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
                    </div>
                </div>

                <!-- Group 2: Service and Patient Information -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Service and Patient Information') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{ __('Service') }}</label>
                                <select name="service_id" class="form-control @error('service_id') is-invalid @enderror">
                                    <option value="">{{ __('Select service') }}</option>
                                    @foreach ($services as $service)
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
                            <div class="col-lg-6">
                                <label>{{ __('Patient') }}</label>
                                <select name="patient_id" class="form-control @error('patient_id') is-invalid @enderror">
                                    <option value="">{{ __('Select patient') }}</option>
                                    @foreach ($patients as $patient)
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
                            <div class="col-lg-6">
                                <label>{{ __('Unregistered Patient') }}</label>
                                <input type="text" name="unregistered_patient"
                                    class="form-control @error('unregistered_patient') is-invalid @enderror"
                                    value="{{ old('unregistered_patient') }}"
                                    placeholder="{{ __('Enter unregistered patient') }}">
                                @error('unregistered_patient')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Service Type') }}</label>
                                <select name="service_type" class="form-control @error('service_type') is-invalid @enderror" required>
                                    <option value="">{{ __('Select service type') }}</option>
                                    <option value="1" {{ old('service_type') == 1 ? 'selected' : '' }}>
                                        {{ __('Inpatient') }}</option>
                                    <option value="2" {{ old('service_type') == 2 ? 'selected' : '' }}>
                                        {{ __('Outpatient') }}</option>
                                    <option value="3" {{ old('service_type') == 3 ? 'selected' : '' }}>
                                        {{ __('Medicine') }}</option>
                                </select>
                                @error('service_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div class="form-group">
                            <label>{{ __('Payment Status') }}</label>
                            <div class="row">
                                @foreach ([1 => __('Paid'), 2 => __('Unpaid'), 3 => __('Pending')] as $value => $label)
                                    <div class="col-md-4">
                                        <div class="card @error('payment_status') is-invalid @enderror" style="cursor: pointer; border: 1px solid #ced4da;">
                                            <div class="card-body text-center">
                                                <input type="radio" id="payment_status_{{ $value }}" name="payment_status" value="{{ $value }}"
                                                    class="form-check-input" {{ old('payment_status') == $value ? 'checked' : '' }} required>
                                                <label for="payment_status_{{ $value }}" class="form-check-label" style="cursor: pointer;">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('payment_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Group 3: Transaction Information -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Transaction Information') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{ __('Transaction Type') }}</label>
                                <select name="transaction_type" class="form-control @error('transaction_type') is-invalid @enderror" required>
                                    <option value="">{{ __('Select transaction type') }}</option>
                                    <option value="1" {{ old('transaction_type') == 1 ? 'selected' : '' }}>
                                        {{ __('Cash') }}</option>
                                    <option value="2" {{ old('transaction_type') == 2 ? 'selected' : '' }}>
                                        {{ __('Non Cash') }}</option>
                                    <option value="3" {{ old('transaction_type') == 3 ? 'selected' : '' }}>
                                        {{ __('Petty Cash') }}</option>
                                    <option value="4" {{ old('transaction_type') == 4 ? 'selected' : '' }}>
                                        {{ __('Receivables') }}</option>
                                </select>
                                @error('transaction_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Amount') }}</label>
                                <input type="number" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" required>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Group 4: Notes -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Notes') }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                                placeholder="{{ __('Enter notes here...') }}">{{ old('notes') }}</textarea>
                            @error('notes')
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
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
@endsection