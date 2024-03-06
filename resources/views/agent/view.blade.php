@extends('layout')
@section('content')
@if($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <p>{{$message}}</p>
</div>
@endif
<button class="btn btn-primary pull-right" onclick="window.location='/agent-form'">Add</button>
<table class="table mt-5">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">address</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($agents) > 0)
            @foreach ($agents as $cont)
                <tr>
                    <th>{{ $cont->id }}</th>
                    <th>{{ $cont->username }}</th>
                    <th>{{ $cont->phone_no }}</th>
                    <th>{{ $cont->address }}</th>
                    <th><a href="/agents/{{ $cont->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/delete/{{ $cont->id }}" class="btn btn-danger">Delete</a>
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
