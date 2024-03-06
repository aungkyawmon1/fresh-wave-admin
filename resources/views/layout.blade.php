<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    
    main {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        border: 1px solid gray;
        background-color:red;
    }
</style>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WaterX</a>
    </div>
    <ul class="nav navbar-nav">
    <li class="nav-item">
                        <a class="nav-link" href="{{route('agents')}}">Agent</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('stocks')}}">Stock</a>
                    </li>
                    <li>
                    <a class="nav-link" href="{{route('posts')}}">Post</a>
                    </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    @endguest
    </ul>
  </div>
</nav>

<div class="container mt-5 main">
        @yield('content')
    </div>

</body>
</html>
