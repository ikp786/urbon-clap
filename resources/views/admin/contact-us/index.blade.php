@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('Contact Us') }}</div>
    <div class="card-body">
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Name</th>                
                <th>Mobile</th>
                <th>E-mail</th>
                <th>Enquiry</th>
                <th>Contact Date</th>

            </tr>
            @forelse ($contacts as $contact)
            <tr>
                <td class="text-center">{{$contact->id}}</td>
                <td>{{$contact->name}}</td>
                <td>{{$contact->mobile}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->enquiry}}</td>
                <td>{{$contact->created_at}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center text-muted py-3">No Contact Us Found</td>
            </tr>
            @endforelse
        </table>
        @if($contacts->total() > $contacts->perPage())
        <br><br>
        {{$contacts->links()}}
        @endif
    </div>
</div>
@endsection
