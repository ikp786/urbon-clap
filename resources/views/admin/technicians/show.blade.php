@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header">{{ __('View Technician') }}</div>

        <div class="card-body">
            <a href="{{ route('technicians.index') }}" class="btn btn-light">Back to List</a>

            <br /><br />
                <table class="table table-borderless">

                    <tr>
                        <th>Photo</th>
                        <td><img src="{{asset('storage/technician_image/'.$technician->profile_pic)}}" style="max-height: 90px; max-width: 90px; border-radius: 15px;"></td>
                    </tr>

                    <tr>
                        <th>ID</th>
                        <td>{{ $technician->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $technician->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $technician->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $technician->mobile }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>{{ $technician->status }}</td>
                    </tr>

                    <tr>
                        <th>Online Status</th>
                        <td>
                            @if($technician->online_status == 'Online')
                            <span style="color: green;">
                            <b>{{ $technician->online_status }}</b>
                            </span>
                            @else
                            {{ $technician->online_status }}
                            @endif
                        </td>
                    </tr>


                    <!-- <tr>
                        <th>Role</th>
                        <td>{{-- $technician->role->title ?? '--' --}}</td>
                    </tr> -->

                </table>




        </div>
    </div>

@endsection
