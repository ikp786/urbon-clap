@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Time Slot List') }}</div>

    <div class="card-body">
        @can('timeslot_create')
        <a href="{{ route('timeslots.create') }}" class="btn btn-primary">Add New Slot</a>
        @endcan

        @can('timeslot_access')
        <a href="{{ route('timeslots.trash') }}" class="btn btn-primary">Go to trash</a>
        @endcan
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Time Slot</th>                
                <th>Status</th>
                <th>
                    Action
                </th>
            </tr>
            @forelse ($timeslots as $timeslot)
            <tr>
                <td class="text-center">{{$timeslot->id}}</td>
                <td>{{$timeslot->slot}}</td>                
                <td><input data-id="{{ $timeslot->id }}" timeslot_id="{{ $timeslot->id }}" status="{{ $timeslot->status }}"  status="{{ $timeslot->status }}"  class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="warning" data-offstyle="dark" type="checkbox" {{ $timeslot->status == 'Active' ? 'checked' : '' }}>
                </td>

                <td>
                    @can('timeslot_edit')
                    <a href="{{ route('timeslots.edit',$timeslot->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit" style="font-size:14px"></i></a>
                    @endcan
                    @can('timeslot_destroy')
                    <form action="{{ route('timeslots.destroy', $timeslot->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to trash this slot?')" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:14px"></i></button>
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
        @if($timeslots->total() > $timeslots->perPage())
        <br><br>
        {{$timeslots->links()}}
        @endif

    </div>
</div>

<script type = "text/javascript" >
  $(document).ready(function() {
    $('.toggle-class').click(function() {        
        var id = $(this).attr('timeslot_id');
      var status = $(this).attr('status') == "Active" ? 'Inactive' : 'Active';      
      $.ajax({
        type: 'POST',
        dataType: "json",
        url: 'timeslot/change-status',
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
