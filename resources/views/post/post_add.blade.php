@extends('layout')
@section('content')
<div class="container h-100 mt-5">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-10 col-md-8 col-lg-6">
      <h3>Add Article</h3>
      <form action="{{ route('post-add') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label class="block mb-4">
                    <span class="sr-only">Choose File</span>
                    <input type="file" name="image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
        </label>

        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
          <label for="title">Description</label>
          <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Create</button>
        <button class="btn btn-secondary" onclick="window.location='/posts'">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection