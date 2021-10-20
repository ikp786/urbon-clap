@extends('layouts.admin')
@section('content')
<style type="text/css">

table  { margin-top:  20px; display: inline-block; overflow: auto; }
th div { margin-top: -20px; position: absolute; }

/* design */
table { border-collapse: collapse; }
tr:nth-child(even) { background: #EEE; }
</style>

<title>Laravel Bootstrap Datepicker</title>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
</head>


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
                    {{ Form::label('Enter Order number', null, []) }}
                    {{ Form::text('order_id',$request->order_id,['class' => 'form-control','placeholder' => "Enter Order number"]) }}                                   
                </div>
                <div class="col-md-3">
                    {{ Form::label('Select Category', null, []) }}
                    {{ Form::select('category_id', $categories, $request->category_id, ['class' => 'form-control','placeholder' => 'Select Category']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('Select Service', null, []) }}
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
                    {{ Form::label('Select Status', null, []) }}
                    {{ Form::select('status', $status, $request->status, ['class' => 'form-control','placeholder' => 'Select Status']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('Select Technician', null, []) }}
                    {{ Form::select('technician_id', $technicians, $request->technician_id, ['class' => 'form-control','placeholder' => 'Select Technician']) }}
                </div>
                <div class="col-md-3">               
                    {{ Form::label('Enter Mobile number', null, []) }}      
                    {{ Form::text('mobile',$request->mobile,['class' => 'form-control','placeholder' => "Enter Mobile"]) }}                                   
                </div>
                <div class="col-md-3">
                    {{ Form::label('Select Start Date', null, []) }}      
                    {{ Form::text('start_date',$request->start_date,['class' => 'form-control date','placeholder' => "Start date"]) }}
                </div>

                <div class="col-md-3">
                    {{ Form::label('End Start Date', null, []) }}      
                    {{ Form::text('end_date',$request->end_date,['class' => 'form-control date','placeholder' => "End date"]) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('Select Time Slot', null, []) }}      
                    {{ Form::select('time_slot_id', $timeslots, $request->time_slot_id, ['class' => 'form-control','placeholder' => 'Select Time']) }}
                </div>
                <div class="col-md-3 d-flex">
                    <button class="btn btn-primary btn-lg" type="submit">
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
        <a href="{{ route('admin.orders.export') }}">
<button>Export</button></a>
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">Order id</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
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
                <td class="text-center">
                    <a href="{{route('admin.orders.detail',$order->order_id)}}">
                        {{$order->order_id}}
                    </a>

                </td>
                <td>{{$order->booking_date}}</td>
                <td>{{$order->booking_time}}</td>
                <td>{{$order->users->name}}</td>
                <td>{{$order->mobile}}</td>
                <td>{{isset($order->services->name) ? $order->services->name : ''}}</td>
                <td>{{isset($order->categories->name) ? $order->categories->name : ''}}</td>
                <td>{{$order->order_amount}}</td>
                <td>{{$order->address}}</td>
                <td>{{$order->description}}</td>
                <td>{{$order->final_payment}}</td>
                <td>
                    <a href="{{ route('technicians.show', isset($order->technicians->id) ? $order->technicians->id : 0) }}">
                        {{isset($order->technicians->name) ? $order->technicians->name : ''}}
                    </a>

                </td>
                <td>
                    {{ Form::select('status', $status, $order->status,['id'=>$order->id,'order_id'=>$order->id, 'category_id'=>$order->category_id, 'status'=>$order->status,'class'=>'status-change']) }}
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


<!-- Technician modal Start -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Lead Technician</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
   <div class="form-group mb-3">

    {!! Form::open(['method' => 'POST','route' => ['orders.assign-order'],'enctype="multipart/form-data"']) !!}
    {{Form::token()}}
    @csrf

    <input type="hidden" name="id" id="order_id">
    <input type="hidden" name="status" id="status">
    <select id="technician-list" name="technician_id" class="form-control">
        <!-- <option>technician-list</option> -->
    </select>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Assigned Lead</button>
</div>
{{Form::open()}}
</div>
</div>
</div>
<!-- Technician Asign modal EOC -->

<script type = "text/javascript" >
  $(document).ready(function() {
    $('.status-change').change(function() {  

        var status = $(this).val();  
        var id = $(this).attr('order_id');
        var category_id = $(this).attr('category_id');

        if (status == 'Assigned') {
            $('#order_id').val(id);
            $('#status').val(status);

            $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'fetch-technicians-by-category',
                data: {
                  'status': status,
                  'category_id': category_id
              },
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              success: function(result) {
                  $('#technician-list').html('<option value="">Select Technician</option>');
                  $.each(result.technicians, function (key, value) {
                    $("#technician-list").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
              }
          });



            $('#exampleModal').modal('show');
        }else{
           if (!confirm("Do you want chage status")){
              return false;
          }       

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
      }

  });

    $('.admin_payment_status').change(function() { 
        if (!confirm("Do you want chage status")){
          return false;
      }       
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
      //   Toast.fire({
      //     icon: 'success',
      //     title: 'Signed in successfully'
      // })
      Swal.fire(
        'GREAT!', 'Status change successfully', 'success')
  }
});
  });

});  

</script>

<script type="text/javascript">
    $('.date').datepicker({  
       format: 'yyyy-mm-dd'
   });  
</script> 
@endsection