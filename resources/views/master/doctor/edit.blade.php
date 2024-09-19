@extends('layouts.app')

@section('title', __('Edit Doctor') . ' | ' . config('app.name'))

@section('breadcrumb')
    <a href="{{ route('master.doctor.index') }}" class="breadcrumb-item">{{ __('Doctors') }}</a>
    <span class="breadcrumb-item active">{{ __('Edit Doctor') }}</span>
@endsection

@section('content')
    <form action="{{ route('master.doctor.update', $doctor->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $doctor->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $doctor->email) }}" required>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">{{ __('Phone') }}</label>
            <input id="phone" name="phone" type="text"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $doctor->phone) }}" required>

            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> --}}

        <div class="form-group">
            <label for="specialty">{{ __('Specialty') }}</label>
            <select id="specialty" name="specialty_id" class="form-control @error('specialty_id') is-invalid @enderror">
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->id }}"
                        {{ old('specialty_id', $doctor->specialty_id) == $specialty->id ? 'selected' : '' }}>
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </select>

            @error('specialty_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    </form>
@endsection
