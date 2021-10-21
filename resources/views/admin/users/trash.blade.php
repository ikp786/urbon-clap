@extends('layouts.admin')

@section('content')


<div class="statbox widget box box-shadow mb-1">
    <div class="widget-header">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <h4>{{__('Manage Users')}}</h4>
            </div>
        </div>
    </div>    
</div>

<div class="card">
    <div class="card-body">
        @can('users_access')
        <a href="{{ route('users.index') }}" class="btn btn-primary">back to list</a>
        @endcan
        <br /><br />

        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Status</th>                
                <th>Action</th>
            </tr>
            @forelse ($users as $user)
            <tr>
                <td class="text-center">{{$user->id}}</td>
                <td><img src="{{asset('storage/user_image/'.$user->profile_pic)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>{{$user->name}}</td>
                <td>{{$user->mobile}}</td>
                <td>{{$user->email}}</td>                
                <td>@if($user->status == 'Active')
                    <span style="color:green;">
                        <b>{{$user->status}}</b>
                    </span>
                    @else
                    <span style="color:red;">
                        {{$user->status}}
                    </span>
                @endif</td>                
                <td>
                    @can('user_restore')
                    <a href="{{ route('users.restore', $user->id) }}" class="btn btn-sm btn-success">Restore</a>
                    @endcan
                    
                    @can('user_delete')
                    <form action="{{ route('users.delete', $user->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to permanent delete this users?')" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:14px"></i></button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No users Found</td>
            </tr>
            @endforelse
        </table>
        @if($users->total() > $users->perPage())
        <br><br>
        {{$users->links()}}
        @endif
    </div>
</div>
@endsection