@extends('layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><strong>Dashboard</strong></div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
                @else
                <div class="alert alert-success">
                    Hello, {{ Auth::user()->username }}, You are logged in!
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection