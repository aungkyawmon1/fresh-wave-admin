@extends('layout')
@section('content')
<div class="container">
    <div class="row ">
    @if (count($data) > 0)
            @foreach ($data as $cont)
            <div class="col-xl-3 col-lg-3">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="mb-4">
                        <h3 class="card-title mb-0">{{$cont->created_at}}</h3>
                    </div>
                    <div class="row align-items-center mb-2 d-flex" style="margin-left:30px">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                {{$cont->count}}
                            </h2>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
            @endforeach
        @else  
        <tr>
                <th>No Data</th>
            </tr>
    @endif
    </div>
</div>
@endsection