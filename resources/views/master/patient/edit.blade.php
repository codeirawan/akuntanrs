@extends('layouts.app')

@section('title', __('Edit Patient') . ' | ' . config('app.name'))

@section('breadcrumb')
    <a href="{{ route('master.patient.index') }}" class="breadcrumb-item">{{ __('Patients') }}</a>
    <span class="breadcrumb-item active">{{ __('Edit Patient') }}</span>
@endsection

@section('content')
    <form action="{{ route('master.patient.update', $patient->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $patient->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="dob">{{ __('Date of Birth') }}</label>
            <input id="dob" name="dob" type="date" 
                class="form-control @error('dob') is-invalid @enderror"
                value="{{ old('dob', $patient->dob) }}" required>

            @error('dob')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="gender">{{ __('Gender') }}</label>
            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
            </select>

            @error('gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <textarea id="address" name="address" 
                class="form-control @error('address') is-invalid @enderror">{{ old('address', $patient->address) }}</textarea>

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">{{ __('Phone') }}</label>
            <input id="phone" name="phone" type="text" 
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $patient->phone) }}" required>

            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    </form>
@endsection
