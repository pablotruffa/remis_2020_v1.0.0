@extends('layout.main')
@section('title','Listado de vehículos')
@push('styles')
<link href="{{ url('css/vehicles.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline my-2">Listado de vehículos</h1>

<a class="btn btn-remis-dark btn-block mb-1" href="{{ route('vehicle.formNew') }}" class="btn btn-primary">Nuevo vehículo</a></p>

@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif
<section id="list">
<div class="table-responsive">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Marca</th>
      <th scope="col">Modelo</th>
      <th scope="col">Patente</th>
      <th scope="col">Acciones</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach($vehicles as $vehicle)
    <tr>
      <td>{{$vehicle->brand->brand}}</td>
      <td>{{$vehicle->model}}</td>
      <td>{{$vehicle->patent}}</td>
      <td><a href="{{ route('vehicle.info', ['id' => $vehicle->id ]) }}">Ver más</a></td>
     
    </tr>
   @endforeach
  </tbody>
</table>
</div>
</section>
</div>
@endsection

