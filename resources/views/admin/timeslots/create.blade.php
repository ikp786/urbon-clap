@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Add New Time Slot') }}</div>

    <div class="card-body">
     @can('timeslot_access')
     <a href="{{ route('timeslots.index') }}" class="btn btn-primary">Go to list</a>
     @endcan
     <form method="POST" action="{{ route('timeslots.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="slot" class="required col-md-4 col-form-label text-md-right">{{ __('Time Slot') }}</label>

            <div class="col-md-6">
                <input id="slot" type="text" class="form-control @error('slot') is-invalid @enderror" name="slot" value="{{ old('slot') }}"  autocomplete="slot" >

                @error('slot')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
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
