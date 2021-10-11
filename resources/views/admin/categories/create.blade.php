@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Add New Category') }}</div>

    <div class="card-body">
       @can('category_access')
       <a href="{{ route('categories.index') }}" class="btn btn-primary">Go to list</a>
       @endcan
       <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" >

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>


        <div class="form-group row">            
        {{ Form::label('Category Thumbnail', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
        <div class="col-md-6">                     
            {{ Form::file('thumbnail',['class' => 'form-control']) }}               
            @if($errors->has('thumbnail'))
            <div class="text-danger">{{ $errors->first('thumbnail') }}</div>
            @endif
        </div>
    </div>



    <div class="form-group row">            
        {{ Form::label('Status', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
        <div class="col-md-6">                     
            {{ Form::checkbox('status', 'Active') }}               
            @if($errors->has('status'))
            <div class="text-danger">{{ $errors->first('stauts') }}</div>
            @endif
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
