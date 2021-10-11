@extends('layouts.admin')

@section('content')
<?php //echo  $categories[0]->id;die; ?>
<div class="card">
    <div class="card-header">{{ __('Edit Category') }}</div>

    <div class="card-body">
     @can('category_access')
     <a href="{{ route('categories.index') }}" class="btn btn-primary">Go to list</a>
     @endcan
     <form method="POST" action="{{ route('categories.update', $categories->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group row">
            <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $categories->name) }}" required autocomplete="name" >
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
                {!! Form::checkbox('status', 'Active', ($categories->status =='Active'?true:null), ['class' => 'field']) !!}
                @if($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
                @endif
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Update') }}
                </button>
            </div>
        </div>
    </form>
</div>
</div>

@endsection
