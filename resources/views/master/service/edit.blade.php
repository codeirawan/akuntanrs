@extends('layouts.app')

@section('title', __('Edit Service') . ' | ' . config('app.name'))

@section('breadcrumb')
    <a href="{{ route('master.service.index') }}" class="breadcrumb-item">{{ __('Services') }}</a>
    <span class="breadcrumb-item active">{{ __('Edit Service') }}</span>
@endsection

@section('content')
    <form action="{{ route('master.service.update', $service->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $service->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" 
                class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description) }}</textarea>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    </form>
@endsection
