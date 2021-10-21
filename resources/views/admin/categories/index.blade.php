@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Category List') }}</div>

    <div class="card-body">
        @can('category_create')
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
        @endcan

        @can('category_access')
        <a href="{{ route('categories.trash') }}" class="btn btn-primary">Go to trash</a>
        @endcan
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Name</th>
                <th>Thumbnail</th>
                <th>Status</th>
                <th>
                    Action
                </th>
            </tr>
            @forelse ($categories as $category)
            <tr>
                <td class="text-center">{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td><img src="{{asset('storage/category/'.$category->thumbnail)}}" style="max-height: 50px; max-width: 50px; border-radius: 15px;"></td>
                <td><input data-id="{{ $category->id }}" category_id="{{ $category->id }}" status="{{ $category->status }}"  status="{{ $category->status }}"  class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="warning" data-offstyle="dark" type="checkbox" {{ $category->status == 'Active' ? 'checked' : '' }}>
                </td>

                <td>
                    @can('category_edit')
                    <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit" style="font-size:14px"></i></a>
                    @endcan
                    @can('category_delete')
                    <form action="{{ route('categories.destroy', $category->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to trash this category?')" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:14px"></i></button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Category Found</td>
            </tr>
            @endforelse
        </table>
        @if($categories->total() > $categories->perPage())
        <br><br>
        {{$categories->links()}}
        @endif

    </div>
</div>

<script type = "text/javascript" >
  $(document).ready(function() {
    $('.toggle-class').click(function() {        
        var id = $(this).attr('category_id');
      var status = $(this).attr('status') == "Active" ? 'Inactive' : 'Active';      
      $.ajax({
        type: 'POST',
        dataType: "json",
        url: 'category/change-status',
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
