@extends('layout')
@section('content')
<div class="container h-100 mt-5">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-10 col-md-8 col-lg-6">
      <h3>Update Article</h3>
      <form action="{{ route('post-edit-submit') }}" method="post">
        @csrf
        <input type="hidden" id="id" name="id" value="{{$post->id}}">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
          <label for="title">Description</label>
          <input type="text" class="form-control" id="description" name="description" value="{{ $post->description }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Upate</button>
        <button class="btn btn-secondary" onclick="window.location='/posts'">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection