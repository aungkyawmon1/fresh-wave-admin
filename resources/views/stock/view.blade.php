@extends('layout')
@section('content')
@if($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <p>{{$message}}</p>
</div>
@endif
<table class="table mt-5">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Agent Name</th>
            <th scope="col">Stock Level</th>
            <th scope="col">Request Stock</th>
        </tr>
    </thead>
    <tbody>
        @if (count($stocks) > 0)
            @foreach ($stocks as $cont)
                <tr>
                    <th>{{ $cont->id }}</th>
                    <th>{{ $cont->username }}</th>
                    <th>{{ $cont->count }}</th>
                    <th>{{ $cont->request_stock}}
                    <th><a href="/stocks/{{ $cont->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/stocks/{{ $cont->id }}" class="btn btn-danger">Delete</a>
                    </th>
                </tr>
            @endforeach
        @else
            <tr>
                <th>No Data</th>
            </tr>
        @endif
    </tbody>
</table>
@endsection
