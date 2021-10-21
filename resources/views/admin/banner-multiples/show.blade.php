@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('View  Banner') }}</div>
    <div class="card-body">
        <a href="{{ route('banner-multiples.index') }}" class="btn btn-light">Back to List</a>
        <br /><br />
        <table class="table table-borderless">
            <tr>
                <th>Photo</th>
                <td><img src="{{asset('storage/banner/'.$banner->banner)}}" style="max-height: 90px; max-width: 90px; border-radius: 15px;"></td>
            </tr>
            <tr>
                <th>ID</th>
                <td>{{ $banner->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $banner->title }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $banner->status }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection