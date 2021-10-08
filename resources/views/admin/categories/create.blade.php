@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Add New Category') }}</div>

    <div class="card-body">
       @can('permission_create')
       <a href="{{ route('admin.categories.list') }}" class="btn btn-primary">Go to list</a>
       @endcan
       <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="form-group row">
            <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Create') }}
                </button>
            </div>
        </div>
    </form>
</div>
</div>

@endsection
