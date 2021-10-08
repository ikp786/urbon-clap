@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Category List') }}</div>

    <div class="card-body">
        @can('permission_create')
        <a href="{{ route('admin.categories.list') }}" class="btn btn-primary">Go to list</a>
        @endcan
        <br /><br />
        <table class="table table-borderless table-hover">
            <tr class="bg-info text-light">
                <th class="text-center">ID</th>
                <th>Name</th>
                <th>
                    &nbsp;
                </th>
            </tr>
            @forelse ($categories as $category)
            <tr>
                <td class="text-center">{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>
                    @can('permission_delete')
                    <form action="{{ route('admin.categories.delete', $category->id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure permission delete this category')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endcan
                    @can('permission_delete')
                    <a href="{{ route('admin.categories.restore',$category->id) }}" class="btn btn-sm btn-warning">restore</a>
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

@endsection
