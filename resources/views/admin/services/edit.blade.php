@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('Edit Service') }}</div>
    <div class="card-body">
       @can('service_access')
       <a href="{{ route('services.index') }}" class="btn btn-primary">Go to list</a>
       @endcan       
        {!! Form::open(['method' => 'PUT','route' => ['services.update', $services->id],'enctype="multipart/form-data"']) !!}
        {{Form::token()}}
        
        <div class="form-group row">
            <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $services->name) }}"  autocomplete="name" >
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
            <div class="col-md-6">                     
                {{ Form::select('category_id', $categories, $services->category_id, ['class' => 'form-control']) }}
                @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">            
            {{ Form::label('Service Amount', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">                     
                {{ Form::text('service_amount',$services->service_amount,['class' => 'form-control']) }}               
                @if($errors->has('service_amount'))
                <div class="text-danger">{{ $errors->first('service_amount') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group row">            
            {{ Form::label('Service Thumbnail', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">                     
                {{ Form::file('service_thumbnail',['class' => 'form-control']) }}               
                @if($errors->has('service_thumbnail'))
                <div class="text-danger">{{ $errors->first('service_thumbnail') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group row">            
            {{ Form::label('Service Description', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">                     
                {{ Form::textarea('service_description',$services->service_description,['rows' => 4,'class' => 'form-control']) }}               
                @if($errors->has('service_description'))
                <div class="text-danger">{{ $errors->first('service_description') }}</div>
                @endif
            </div>
        </div>

        <div class="form-group row">            
        {{ Form::label('Status', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
        <div class="col-md-6">                     
            {{-- Form::checkbox('status', ($services->status == 'Active' ) ? 'Checked' : '') --}}
            {!! Form::checkbox('status', 'Active', ($services->status =='Active'?true:null), ['class' => 'field']) !!}
            @if($errors->has('status'))
            <div class="text-danger">{{ $errors->first('stauts') }}</div>
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
