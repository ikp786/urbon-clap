@extends('layouts.admin')
@section('content')
<div class="statbox widget box box-shadow mb-1">
    <div class="widget-header">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <h4>{{__('Manage Multipe Banner')}}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @can('banner_multiple_create')
        <a href="{{ route('banner-multiples.create') }}" class="btn btn-primary">Add New Banner</a>
        @endcan

        @can('banner_multiple_access')
        <a href="{{ route('banner-multiples.trash') }}" class="btn btn-primary">Got to trash list</a>
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
                <td><img src="{{asset('storage/banner/'.$banner->banner)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td>{{$banner->title}}</td>                
                <td><input data-id="{{ $banner->id }}" technician_id="{{ $banner->id }}" status="{{ $banner->status }}"  status="{{ $banner->status }}"  class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="warning" data-offstyle="dark" type="checkbox" {{ $banner->status == 'Active' ? 'checked' : '' }}>
                </td>                
                <td>
                    @can('banner_multiple_show')
                    <a href="{{ route('banner-multiples.show', $banner->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye" style="font-size:14px"></i></a>
                    @endcan
                    @can('banner_multiple_edit')
                    <a href="{{ route('banner-multiples.edit', $banner->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit" style="font-size:14px"></i></a>
                    @endcan
                    @can('banner_multiple_delete')
                    <form action="{{ route('banner-multiples.destroy', $banner->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:14px"></i></button>
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
<script type = "text/javascript" >
  $(document).ready(function() {
    $('.toggle-class').click(function() {        
        var id = $(this).attr('technician_id');
        var status = $(this).attr('status') == "Active" ? 'Inactive' : 'Active';      
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'banner-multiple/change-status',
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