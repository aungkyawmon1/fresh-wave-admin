@extends('layout')
@section('content')
<div class="container h-100 mt-5">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-10 col-md-8 col-lg-6">
      <h3>Add Stock</h3>
      <form action="{{ route('stock-edit-submit') }}" method="post">
        @csrf
        <input type="hidden" id="id" name="id" value="{{$stock->id}}">
        <div class="form-group">
          <label for="title">Agent Name</label>
          <input type="text" class="form-control" id="username" name="username" value="{{ $stock->username }}" required>
        </div>
        <input type="hidden" id="count" name="count" value = "{{$stock->count}}">
        <div class="form-group">
          <label for="title">Request Count</label>
          <input type="text" class="form-control" id="request_stock" name="request_stock" value="{{ $stock->request_stock }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update</button>
        <button class="btn btn-secondary" onclick="window.location='/stocks'">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection