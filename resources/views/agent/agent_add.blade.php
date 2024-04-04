@extends('layout')
@section('content')
<div class="container h-100 mt-5">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-10 col-md-8 col-lg-6">
      <h3>Add Agent</h3>
      <form action="{{ route('agent-add') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="title">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="title">Password</label>
          <input type="text" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="title">PhoneNo</label>
          <input type="text" class="form-control" id="phone_no" name="phone_no" required>
          @if ($errors->has('error'))
            <span class="text-danger">{{ $errors->first('error') }}</span>
          @endif
        </div>
        <div class="form-group">
          <label for="title">Latitude</label>
          <input type="text" class="form-control" id="latitude" name="latitude" required>
        </div>
        <div class="form-group">
          <label for="title">Longitude</label>
          <input type="text" class="form-control" id="longitude" name="longitude" required>
        </div>
        <div class="form-group">
          <label for="body">Address</label>
          <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        <div class="form-group">
        <!--<select class="form-control" name="role_id">
          @foreach($roles as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
          @endforeach
        </select>!-->
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Create</button>
        <button class="btn btn-secondary" onclick="window.location='/agents'">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection