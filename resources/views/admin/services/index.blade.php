@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('Service List') }}</div>
    <div class="card-body">
        @can('permission_create')
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">Add New Service</a>
        @endcan
        @can('permission_create')
        <a href="{{ route('admin.services.trash') }}" class="btn btn-primary">Go to trash</a>
        @endcan
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Service Amount</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Action</th>
            </tr>
            @forelse ($services as $service)
            <tr>
                <td class="text-center">{{$service->id}}</td>
                <td>{{$service->name}}</td>
                <td>{{isset($service->categories->name) ? $service->categories->name : ''}}</td>
                <td>{{$service->service_amount}}</td>
                <td>{{$service->service_description}}</td>
                <td><img src="{{$service->service_thumbnail}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>
                    @can('permission_edit')
                    <a href="{{ route('admin.services.edit',$service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan
                    @can('permission_delete')
                    <form action="{{ route('admin.services.destroy', $service->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to trah this Service?')" class="btn btn-sm btn-danger">Trash</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Service Found</td>
            </tr>
            @endforelse
        </table>
        @if($services->total() > $services->perPage())
        <br><br>
        {{$services->links()}}
        @endif
    </div>
</div>
@endsection