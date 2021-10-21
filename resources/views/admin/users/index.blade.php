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
    <form action="{{route('users.index')}}" method="GET">
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" maxlength="32" class="form-control mb-3 mb-md-0" name="name" placeholder="User Name" value="{{$request->name}}" onkeypress="return IsAlphaApos(event, this.value, '32')"> 
                </div>
                <div class="col-md-3">
                    <input type="text" maxlength="50" class="form-control mb-3 mb-md-0" name="email" placeholder="Email Address" value="{{$request->email}}"> 
                </div>
                <div class="col-md-3">
                    <input type="text" maxlength="9" class="form-control mb-3 mb-md-0" name="mobile" placeholder="Mobile Number" value="{{$request->mobile}}" onkeypress="return IsNumber(event, this.value, '9')"> 
                </div>
                <div class="col-md-3 d-flex">
                    <button class="btn btn-primary mr-3" type="submit">
                        Filter
                    </button>
                    <a href="{{ route('users.index') }}">
                        <button class="btn btn-danger" type="button" id="ClearFilter">
                            Clear Filter
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<div class="card">
    <!-- <div class="card-header">{{ __('Users List') }}</div> -->

    <div class="card-body">
        @can('user_create')
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
        @endcan
        @can('users_access')            
        <a href="{{ route('users.trash') }}" class="btn btn-primary">Got to trash list</a>
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
                <!-- <th>Role</th> -->
                <th>Action</th>
            </tr>
            @forelse ($users as $user)
            <tr>
                <td class="text-center">{{$user->id}}</td>
                <td><img src="{{asset('storage/user_image/'.$user->profile_pic)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>{{$user->name}}</td>                            
                <td>{{$user->mobile}}</td>
                <td>{{$user->email}}</td>
                <td><input data-id="{{ $user->id }}" user_id="{{ $user->id }}" status="{{ $user->status }}"  status="{{ $user->status }}"  class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="warning" data-offstyle="dark" type="checkbox" {{ $user->status == 'Active' ? 'checked' : '' }}>
                </td>
                <!-- <td>{{--$user->role->title ?? "--"--}}</td> -->
                <td>
                    @can('user_show')
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye" style="font-size:14px"></i></a>
                    @endcan
                    @can('user_edit')
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit" style="font-size:14px"></i></a>
                    @endcan
                    @can('user_delete')
                    <form action="{{ route('users.destroy', $user->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to delete this User?')" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:14px"></i></button>
                    </form>
                    @endcan
                    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
            </tr>
            @endforelse
        </table>




        @if($users->total() > $users->perPage())
        <br><br>
        {{$users->links()}}
        @endif

    </div>
</div>

<script type = "text/javascript" >
  $(document).ready(function() {
    $('.toggle-class').click(function() {                
        var id = $(this).attr('user_id');
        var status = $(this).attr('status') == "Active" ? 'Inactive' : 'Active';      
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'user/change-status',
            data: {
              'status': status,
              'id': id
          },
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          success: function(data) {
              Swal.fire(
                'GREAT!', 'Status change successfully', 'success')
          }
      });
    });
}) 
</script>

@endsection
