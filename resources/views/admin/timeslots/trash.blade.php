
@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Time Slot List') }}</div>

    <div class="card-body">
        @can('timeslot_access')
        <a href="{{ route('timeslots.index') }}" class="btn btn-primary">Go to list</a>
        @endcan
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @forelse ($timeslots as $timeslot)
            <tr>
                <td class="text-center">{{$timeslot->id}}</td>
                <td>{{$timeslot->slot}}</td>                
                <td>
                    @can('timeslot_delete')
                    <form action="{{ route('timeslots.delete', $timeslot->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to delete this Slot')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endcan
                    @can('timeslot_restore')
                    <a href="{{ route('timeslots.restore',$timeslot->id) }}" class="btn btn-sm btn-warning">restore</a>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Slot Found</td>
            </tr>
            @endforelse
        </table>
        @if($timeslots->total() > $timeslots->perPage())
        <br><br>
        {{$timeslots->links()}}
        @endif

    </div>
</div>

@endsection
