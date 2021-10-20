@extends('layouts.admin')
@section('content')

<div class="statbox widget box box-shadow mb-1">
    <div class="widget-header">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <h4>{{__('Manage Banner')}}</h4>
            </div>
        </div>
    </div>    
</div>
<div class="card">
    <div class="card-body">
        @can('banner_multiple_access')
        <a href="{{ route('banner-multiples.index') }}" class="btn btn-primary">back to list</a>
        @endcan
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Banner</th>
                <th>Title</th>                
                <th>Status</th>                
                <th>Action</th>
            </tr>
            @forelse ($banners as $banner)
            <tr>
                <td class="text-center">{{$banner->id}}</td>
                <td><img src="{{asset('storage/app/public/banner/'.$banner->banner)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>{{$banner->title}}</td>                
                <td>@if($banner->status == 'Active')
                    <span style="color:green;">
                        <b>{{$banner->status}}</b>
                    </span>
                    @else
                    <span style="color:red;">
                        {{$banner->status}}
                    </span>
                @endif</td>

                <td>
                    @can('banner_multiple_restore')
                    <a href="{{ route('banner-multiples.restore', $banner->id) }}" class="btn btn-sm btn-success">Restore</a>
                    @endcan
                    
                    @can('banner_multiple_delete')
                    <form action="{{ route('banner-multiples.delete', $banner->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to permanent delete this banner?')" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:14px"></i></button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Banners Found</td>
            </tr>
            @endforelse
        </table>
        @if($banners->total() > $banners->perPage())
        <br><br>
        {{$banners->links()}}
        @endif
    </div>
</div>
@endsection