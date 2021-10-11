@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('Service List') }}</div>
    <div class="card-body">
        @can('service_create')
        <a href="{{ route('services.create') }}" class="btn btn-primary">Add New Service</a>
        @endcan
        @can('service_access')
        <a href="{{ route('services.trash') }}" class="btn btn-primary">Go to trash</a>
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
                <th>Status</th>
                <th>Action</th>
            </tr>
            @forelse ($services as $service)
            <tr>
                <td class="text-center">{{$service->id}}</td>
                <td>{{$service->name}}</td>
                <td>{{isset($service->categories->name) ? $service->categories->name : ''}}</td>
                <td>{{$service->service_amount}}</td>
                <td>{{$service->service_description}}</td>
                <td><img src="{{asset('storage/app/public/service/'.$service->service_thumbnail)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>  {{-- Form::checkbox('status', 'Active', ($service->status =='Active'?true:null), ['class' => 'field']) --}} 

                    <td><input data-id="{{ $service->id }}" service_id="{{ $service->id }}" service_id="{{ $service->status }}"  status="{{ $service->status }}"  class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="warning" data-offstyle="dark" type="checkbox" {{ $service->status == 'Active' ? 'checked' : '' }}>
                </td>

                </td>
                <td>
                    @can('service_edit')
                    <a href="{{ route('services.edit',$service->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                    @endcan
                    @can('service_destroy')
                    <form action="{{ route('services.destroy', $service->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to trash this Service?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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


<script type = "text/javascript" >
  $(document).ready(function() {
    $('.toggle-class').click(function() {        
        var id = $(this).attr('service_id');
      var status = $(this).attr('status') == "Active" ? 'Inactive' : 'Active';      
      $.ajax({
        type: 'POST',
        dataType: "json",
        url: 'services/change-status',
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