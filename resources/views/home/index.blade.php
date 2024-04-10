@extends('layouts.app')
@section('title',$viewData["title"])
@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4 mb-2">
        <img src="{{ asset('/img/camiseta-1.jpeg')}}" class="img-fluid rounded">
    </div>

    <div class="col-md-6 col-lg-4 mb-2">
        <img src="{{ asset('/img/camiseta-2.jpeg')}}" class="img-fluid rounded">
    </div>

    <div class="col-md-6 col-lg-4 mb-2">
        <img src="{{ asset('/img/camiseta-3.jpeg')}}" class="img-fluid rounded">
    </div>



</div>
@endsection