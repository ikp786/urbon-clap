@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('View Order Detail') }}</div>
    <div class="card-body">
        <a href="{{ route('orders.index') }}" class="btn btn-light">Back to List</a>
        <br /><br />
        <table class="table table-borderless">

            <tr>
                <th>Order Id</th>
                <td>{{ $order->order_id }}</td>
            </tr>
            <tr>
                <th>Order Amount</th>
                <td>{{ $order->order_amount }}</td>
            </tr>
            <tr>
                <th>Final Payment</th>
                <td>{{ $order->final_payment }}</td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>{{ $order->users->name }}</td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>{{ $order->mobile }}</td>
            </tr>

            <tr>
                <th>Category Name</th>
                <td>{{ $order->categories->name }}</td>
            </tr>
            <tr>
                <th>Service Name</th>
                <td>{{ $order->service_name }}</td>
            </tr>
            <tr>
                <th>Booking Date</th>
                <td>{{ $order->booking_date }}</td>
            </tr>
            <tr>
                <th>Booking</th>
                <td>{{ $order->booking_time }}</td>
            </tr>
            
            <tr>
                <th>Technician Name</th>
                <td>{{ isset($order->technicians->name) ? $order->technicians->name : '' }}</td>
            </tr>
            <tr>
                <th>Technician Mobile</th>
                <td>{{ isset($order->technicians->mobile) ? $order->technicians->mobile : '' }}</td>
            </tr>

            <tr>
                <th>Description</th>
                <td>{{ $order->description }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $order->status }}</td>
            </tr>

            <tr>
                <th>Admin Payment Received</th>
                <td>
                    @if($order->admin_payment_status == 'Paid')
                    <span style="color:green;">
                    {{ $order->admin_payment_status }}
                    </span>
                    @else
                    <span style="color:red">
                    {{ $order->admin_payment_status }}
                    </span>
                    @endif
                </td>
            </tr>

        </table>




    </div>
</div>

@endsection
