@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('Add New Banner') }}</div>
    <div class="card-body">
        @can('banner_multiple_access')
        <a href="{{ route('banner-multiples.index') }}" class="btn btn-primary">Back to List</a>
        @endcan
        <form method="POST" action="{{ route('banner-multiples.store') }}" enctype="multipart/form-data">
            @csrf           
            <div class="form-group row">
                <label for="title" class="required col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                <div class="col-md-6">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"  autocomplete="title" >
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">            
                {{ Form::label('Banner', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
                <div class="col-md-6">                     
                    {{ Form::file('banner',['class' => 'form-control']) }}               
                    @if($errors->has('banner'))
                    <div class="text-danger">{{ $errors->first('banner') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">            
                {{ Form::label('Status', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
                <div class="col-md-6">                     
                    {{ Form::checkbox('status', 'Active', ['class' => 'col-md-4 col-form-label text-md-right']) }}               
                    @if($errors->has('status'))
                    <div class="text-danger">{{ $errors->first('stauts') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection