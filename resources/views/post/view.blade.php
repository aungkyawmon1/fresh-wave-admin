@extends('layout')
@section('content')
@if($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <p>{{$message}}</p>
</div>
@endif
<button class="btn btn-primary pull-right" onclick="window.location='/post-form'">Add</button>
<table class="table mt-5">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Created Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($posts) > 0)
            @foreach ($posts as $cont)
                <tr>
                    <th>{{ $cont->id }}</th>
                    <th>{{ $cont->title }}</th>
                    <th>{{ $cont->description }}</th>
                    <th>{{ $cont->created_at }}</th>
                    <th><a href="/posts/{{ $cont->id }}/edit" class="btn btn-primary">Edit</a>
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
{{ $posts->links() }}
@endsection
