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
    <form action="{{route('technicians.index')}}" method="GET">
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
                    <a href="{{ route('technicians.index') }}">
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
    <div class="card-body">
        @can('user_create')
        <a href="{{ route('technicians.create') }}" class="btn btn-primary">Add New Technician</a>
        @endcan

        @can('user_create')
        <a href="{{ route('technicians.trash') }}" class="btn btn-primary">Got to trash list</a>
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
                <td><input data-id="{{ $technician->id }}" technician_id="{{ $technician->id }}" status="{{ $technician->status }}"  status="{{ $technician->status }}"  class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="warning" data-offstyle="dark" type="checkbox" {{ $technician->status == 'Active' ? 'checked' : '' }}>
                </td>
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
                    @can('technician_show')
                    <a href="{{ route('technicians.show', $technician->id) }}" class="btn btn-sm btn-success">Show</a>
                    @endcan
                    @can('technician_edit')
                    <a href="{{ route('technicians.edit', $technician->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan
                    @can('technician_delete')
                    <form action="{{ route('technicians.destroy', $technician->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Trash</button>
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
<script type = "text/javascript" >
  $(document).ready(function() {
    $('.toggle-class').click(function() {        
        var id = $(this).attr('technician_id');
        var status = $(this).attr('status') == "Active" ? 'Inactive' : 'Active';      
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'technician/change-status',
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