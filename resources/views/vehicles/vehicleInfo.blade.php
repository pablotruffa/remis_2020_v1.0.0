@extends('layout.main')
@section('title','Información del vehículo')

@push('styles')
<link href="{{ url('css/vehicles.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline my-2">Información del vehículo</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif
    
    @if($vehicle->picture != null || $vehicle->picture != '' )
    <div><img width="200" src="{{ url('vehicle_pictures/' . $vehicle->picture) }}" alt="{{ $vehicle->brand->brand .' '. $vehicle->model }}"></div>
    @else
    <p id="image" class="form-control-plaintext">No dispone imagen del vehículo.</p>
    @endif
    
    <ul class="data-list">
        <li><span>Marca:</span><span>{{$vehicle->brand->brand}}</span></li>
        <li><span>Modelo:</span><span>{{$vehicle->model}}</span></li>
        <li><span>Color:</span><span>{{$vehicle->color->color}}</span></li>
        <li><span>Año</span><span>{{$vehicle->year}}</span></li>
        <li><span>Patente</span><span>{{$vehicle->patent}}</span></li>
    </ul>

    <div><a class="btn btn-remis-dark btn-block" href="{{ route('vehicle.formEdit', ['id' => $vehicle->id]) }}">Editar</a></div>
    <div>
        <form action="{{ route('vehicle.delete', ['id' => $vehicle->id ]) }}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-remis-dark btn-block mt-1">Eliminar</button>
        </form>
    </div>

@if($vehicle->driver)
<p>Chofer asignado: {{$vehicle->driver->first_name.' '.$vehicle->driver->last_name}}</p>

<form action="{{ route('vehicle.unassign_driver',['id' => $vehicle->id]) }}" method="post">
    @csrf
    @method('PUT')
    <button class="btn btn-remis-dark btn-block">Desasignar chofer</button>
    </form>
@else
<p>El vehiculo se encuentra libre para asignar.</p>
<a href="{{ route('vehicle.form_assign_driver',['id' => $vehicle->id]) }}">Asignar chofer</a>
@endif
</div>
@endsection