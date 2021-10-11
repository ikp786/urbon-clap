@extends('layouts.admin')

@section('content')


<div class="statbox widget box box-shadow mb-1">
    <div class="widget-header">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <h4>{{__('Manage Technicians')}}</h4>
            </div>
        </div>
    </div>    
</div>

<div class="card">
    <div class="card-body">
        @can('user_create')
        <a href="{{ route('technicians.index') }}" class="btn btn-primary">back to list</a>
        @endcan
        <br /><br />

        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <!-- <th>Role</th> -->
                <th>Status</th>
                <th>Online Status</th>
                <th>Action</th>
            </tr>
            @forelse ($technicians as $technician)
            <tr>
                <td class="text-center">{{$technician->id}}</td>
                <td><img src="{{asset('storage/app/public/technician_image/'.$technician->profile_pic)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>{{$technician->name}}</td>
                <td>{{$technician->mobile}}</td>
                <td>{{$technician->email}}</td>
                <!-- <td>{{--$technician->role->title ?? "--"--}}</td> -->
                <td>@if($technician->status == 'Active')
                    <span style="color:green;">
                        <b>{{$technician->status}}</b>
                    </span>
                    @else
                    <span style="color:red;">
                        {{$technician->status}}
                    </span>
                    @endif</td>
                <td>
                    @if($technician->online_status == 'Online')
                    <span style="color:green;">
                        <b>{{$technician->online_status}}</b>
                    </span>
                    @else
                    <span style="color:red;">
                        {{$technician->online_status}}
                    </span>
                    @endif
                </td>
                <td>
                    @can('technician_restore')
                    <a href="{{ route('technicians.restore', $technician->id) }}" class="btn btn-sm btn-success">Restore</a>
                    @endcan
                    
                    @can('technician_delete')
                    <form action="{{ route('technicians.delete', $technician->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to permanent delete this Technicians?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No technicians Found</td>
            </tr>
            @endforelse
        </table>
        @if($technicians->total() > $technicians->perPage())
        <br><br>
        {{$technicians->links()}}
        @endif
    </div>
</div>
@endsection