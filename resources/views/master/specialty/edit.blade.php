@extends('layouts.app')

@section('title', __('Edit Specialty') . ' | ' . config('app.name'))

@section('breadcrumb')
    <a href="{{ route('master.specialty.index') }}" class="breadcrumb-item">{{ __('Specialties') }}</a>
    <span class="breadcrumb-item active">{{ __('Edit Specialty') }}</span>
@endsection

@section('content')
    <form action="{{ route('master.specialty.update', $specialty->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $specialty->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    </form>
@endsection
