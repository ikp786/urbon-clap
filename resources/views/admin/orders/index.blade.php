@extends('layouts.admin')
@section('content')
<style type="text/css">

table  { margin-top:  20px; display: inline-block; overflow: auto; }
th div { margin-top: -20px; position: absolute; }

/* design */
table { border-collapse: collapse; }
tr:nth-child(even) { background: #EEE; }

</style>
<div class="statbox widget box box-shadow mb-1">
    <div class="widget-header">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <h4>{{__('Manage Orders')}}</h4>
            </div>
        </div>
    </div>
    <form action="{{route('orders.index')}}" method="GET">
        <div class="widget-content widget-content-area">
            <div class="row">   
                <div class="col-md-3">                     
                    {{ Form::text('order_id',$request->order_id,['class' => 'form-control','placeholder' => "Enter Order Id"]) }}                                   
                </div>
                <div class="col-md-3">
                    {{ Form::select('category_id', $categories, $request->category_id, ['class' => 'form-control','placeholder' => 'Select Category']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('service_id', $services, $request->service_id, ['class' => 'form-control','placeholder' => 'Select Service']) }}
                </div>
                @php
                $status = [
                'Pending'       =>  'Pending',
                'Accepted'      =>  'Accepted',
                'Assigned'      =>  'Assigned',
                'In-Process'    =>  'In-Process',
                'Completed'     =>  'Completed',
                'Canceled'      =>  'Canceled'
                ];
                @endphp
                <div class="col-md-3">
                    {{ Form::select('status', $status, $request->status, ['class' => 'form-control','placeholder' => 'Select Status']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('technician_id', $technicians, $request->technician_id, ['class' => 'form-control','placeholder' => 'Select Technician']) }}
                </div>
                <div class="col-md-3">                     
                    {{ Form::text('mobile',$request->mobile,['class' => 'form-control','placeholder' => "Enter Mobile"]) }}                                   
                </div>
                <div class="col-md-3 d-flex">
                    <button class="btn btn-primary mr-3" type="submit">
                        Filter
                    </button>
                    <a href="{{ route('orders.index') }}">
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

        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">Order id</th>
                <th>Customer Name</th>
                <th>Customer Mobile </th>
                <th>Category Name</th>
                <th>Service Name</th>
                <th>Service Amount</th>
                <th>Address</th>
                <th>Description</th>
                <th>Final Amount</th>                
                <th>Asign Technician</th>
                <th>Order Status</th>
                <th>Admin Payment Received</th>
            </tr>
            @forelse ($orders as $order)
            <tr>
                <td class="text-center">{{$order->order_id}}</td>
                <td>{{$order->users->name}}</td>
                <td>{{$order->mobile}}</td>
                <td>{{isset($order->services->name) ? $order->services->name : ''}}</td>
                <td>{{isset($order->categories->name) ? $order->categories->name : ''}}</td>
                <td>{{$order->order_amount}}</td>
                <td>{{$order->address}}</td>
                <td>{{$order->description}}</td>
                <td>{{$order->final_payment}}</td>
                <td>
                    <select data-id="{{ $order->id }}" order_id="{{ $order->id }}" status="{{ $order->status }}"  class="toggle-class" data-toggle="toggle">
                        <option value="">Assign</option>
                        @foreach($order->technicians as $key => $val)
                        <option @if($val->id == $order->technician_id){{'selected'}} @endif value="{{$val->name}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    {{ Form::select('status', $status, $order->status,['id'=>$order->id,'order_id'=>$order->id,'status'=>$order->status,'class'=>'status-change']) }}
                </td>
                <td>
                    {{ Form::select('admin_payment_status', ['Paid'=>'Paid','Unpaid'=>'Unpaid'], $order->admin_payment_status,['admin_payment_status_order_id'=>$order->id,'status'=>$order->status,'class'=>'admin_payment_status']) }}                
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Order Found</td>
            </tr>
            @endforelse
        </table>
        @if($orders->total() > $orders->perPage())
        <br><br>
        {{$orders->links()}}
        @endif
    </div>
</div>


<script type = "text/javascript" >
  $(document).ready(function() {
    $('.status-change').change(function() {        
        var id = $(this).attr('order_id');
        var status = $(this).val();        
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'change-status',
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

    $('.admin_payment_status').change(function() {        
        var id = $(this).attr('admin_payment_status_order_id');
        var status = $(this).val();                
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'admin-payment-received-status',
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

});  

</script>
@endsection