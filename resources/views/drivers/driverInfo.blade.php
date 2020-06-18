@extends('layout.main')
@section('title','Información del chofer')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline mt-2">Información del chofer</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif
<section>
    <div>
    @if($driver->picture != null || $driver->picture != '' )
        <img id="driver-profile" src="{{ url('driver_profile_pictures/' . $driver->picture) }}" alt="{{ $client->first_name .' '. $client->last_name }}">
        @else
        <p id="image" class="form-control-plaintext">No dispone imagen de perfil.</p>
        @endif
    </div>
    <ul id="driver-data">
        <li><span>Nombre:</span><span>{{$driver->first_name}}</span></li>
        <li><span>Apellido:</span><span>{{$driver->last_name}}</span></li>
        <li><span>Email</span><span>{{$driver->email}}</span></li>
        <li><span>DNI / Pasaporte</span><span>{{$driver->identification_card_number}}</span></li>
        <li><span>Licencia para conducir:</span><span>{{$driver->car_license}}</span></li>
        <li><span>Fecha de nacimiento:</span><span>{{$dt->day.'/'.$dt->month.'/'.$dt->year }}</span></li>
    </ul> 
    @if($driver->deleted_at != null)
    <div>
    <form action="{{route('driver.restore',['id' => $driver->id])}}" method="post">
        @csrf
        @method('PATCH')
        <button class="btn" id="patch-driver">Restablecer</button>
        </form>
    </div>
    @else

    @if($driver->assigned_vehicle == null)
    <div><a class="btn" id="assign-vehicle" href="{{ route('driver.form_assign_vehicle',['id' => $driver->id]) }}">Asignar vehículo</a></div>
    @else
    <div class="my-2">
        <p>El chofer tiene asignado el siguiente vehículo:</p>
        <ul id="data-assigned">
            <li>Marca: {{$driver->vehicle->brand->brand}}</li>
            <li>Modelo: {{$driver->vehicle->model}}</li>
            <li>Color: {{$driver->vehicle->color->color}}</li>
            <li>Patente: {{$driver->vehicle->patent}}</li>
        </ul>
    </div>
    <div>
    
    <form action="{{ route('driver.unassign_vehicle',['id' => $driver->id]) }}" method="post">
    @csrf
    @method('PUT')
    <button class="btn" id="unassign-vehicle">Desasignar vehículo</button>
    </form>
    @endif
    
    <div><a class="btn" id="edit-driver" href="{{ route('driver.formEdit',['id' => $driver->id]) }}">Editar</a></div>
    
    <div>
        <form action="{{route('driver.delete',['id' => $driver->id])}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn" id="delete-driver">Eliminar</button>
        </form>
    </div>
</section>
</div>
@endif
@endsection