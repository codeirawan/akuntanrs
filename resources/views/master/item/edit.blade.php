@extends('layouts.app')

@section('title', __('Edit Item') . ' | ' . config('app.name'))

@section('breadcrumb')
    <a href="{{ route('master.item.index') }}" class="breadcrumb-item">{{ __('Items') }}</a>
    <span class="breadcrumb-item active">{{ __('Edit Item') }}</span>
@endsection

@section('content')
    <form action="{{ route('master.item.update', $item->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code">{{ __('Code') }}</label>
            <input id="code" name="code" type="text" 
                class="form-control @error('code') is-invalid @enderror"
                value="{{ old('code', $item->code) }}" required>

            @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $item->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="unit">{{ __('Unit') }}</label>
            <input id="unit" name="unit" type="text" 
                class="form-control @error('unit') is-invalid @enderror"
                value="{{ old('unit', $item->unit) }}" required>

            @error('unit')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <input id="price" name="price" type="number" step="0.01" 
                class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', $item->price) }}" required>

            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">{{ __('Category') }}</label>
            <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                <option value="pharmacy" {{ old('category', $item->category) == 'pharmacy' ? 'selected' : '' }}>
                    {{ __('Pharmacy') }}</option>
                <option value="logistic" {{ old('category', $item->category) == 'logistic' ? 'selected' : '' }}>
                    {{ __('Logistic') }}</option>
                <option value="general" {{ old('category', $item->category) == 'general' ? 'selected' : '' }}>
                    {{ __('General') }}</option>
            </select>

            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    </form>
@endsection
