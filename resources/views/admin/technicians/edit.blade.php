@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Edit Technician') }}</div>

    <div class="card-body">
        @can('technician_access')
        <a href="{{ route('technicians.index') }}" class="btn btn-primary">Back to List</a>
        @endcan
        <form method="POST" action="{{ route('technicians.update', $technicians->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{$technicians->id}}">
            {{--
            <div class="form-group row">
                <label for="role_id" class="required col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                <div class="col-md-6">
                    <select id="role_id" type="text" class="form-control @error('role_id') is-invalid @enderror" name="role_id"  autocomplete="role_id" autofocus>
                        @foreach ($roles as $id => $role)
                        <option value="{{$id}}" {{ (old('role_id',$technician->role->id ?? "") == $id ) ? 'selected' : '' }}>{{$role}}</option>
                        @endforeach
                    </select>

                    @error('role_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            --}}
            <div class="form-group row">
                <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $technicians->name) }}"  autocomplete="name" >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="required col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $technicians->email) }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="required col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                <div class="col-md-6">
                    <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile', $technicians->mobile) }}"  autocomplete="mobile">
                    @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
              <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
              <div class="col-md-6">                     
                {{ Form::select('category_id', $categories, $technicians->category_id, ['class' => 'form-control']) }}
                @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">            
            {{ Form::label('Profile Photo', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">                     
                {{ Form::file('profile_pic',['class' => 'form-control']) }}               
                @if($errors->has('profile_pic'))
                <div class="text-danger">{{ $errors->first('profile_pic') }}</div>
                @endif
            </div>
        </div>

        <div class="form-group row">            
            {{ Form::label('Profile Photo', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">                     
                <img src="{{asset('storage/app/public/technician_image/'.$technicians->profile_pic)}}" style="max-height: 90px; max-width: 90px; border-radius: 15px;">
            </div>
        </div>

        <div class="form-group row">            
            {{ Form::label('Status', null, ['class' => 'required col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">                     
                {{-- Form::checkbox('status', ($technicians->status == 'Active' ) ? 'Checked' : '') --}}
                {!! Form::checkbox('status', 'Active', ($technicians->status =='Active'?true:null), ['class' => 'field']) !!}
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