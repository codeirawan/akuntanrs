@extends('layouts.app')

@section('title', __('Edit Supplier') . ' | ' . config('app.name'))

@section('breadcrumb')
    <a href="{{ route('master.supplier.index') }}" class="breadcrumb-item">{{ __('Suppliers') }}</a>
    <span class="breadcrumb-item active">{{ __('Edit Supplier') }}</span>
@endsection

@section('content')
    <form action="{{ route('master.supplier.update', $supplier->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $supplier->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="contact">{{ __('Contact') }}</label>
            <input id="contact" name="contact" type="text" 
                class="form-control @error('contact') is-invalid @enderror"
                value="{{ old('contact', $supplier->contact) }}" required>

            @error('contact')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <textarea id="address" name="address" 
                class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address) }}</textarea>

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    </form>
@endsection
