@extends('layout.main')
@section('title','Asignación de vehículos')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1  class="underline mt-2">Asignación de vehículos</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif


<p>Chofer: {{ $driver->first_name.' '.$driver->last_name }} <br>
Seleccionar un vehículo de las opciones y luego asignar.
</p>
<div><form action="{{ route('driver.assign_vehicle',['id' => $driver->id]) }}" method="post">
@csrf
@method('PUT')
@foreach($available_vehicles as $av)
<div class="form-check mt-1">
  <input class="form-check-input" type="radio" name="vehicle" id="{{$av->id}}" value="{{$av->id}}">
  <label class="form-check-label" for="{{$av->id}}">
  {{ $av->brand->brand.' '.$av->model.' '.$av->color->color.' '.$av->patent }}
  </label>
</div>
@endforeach
<button class="btn btn-remis-dark btn-block mt-2">Asignar</button>
</form></div>
</div>

@endsection