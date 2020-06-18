@extends('layout.main')
@section('title','Cambiar chofer')
@push('styles')
    <link href="{{ url('css/switchDriver.css') }}" rel="stylesheet">
@endpush


@section('main')
<div class="main-content">
<h1 class="underline">Cambiar chofer de la reserva</h1>
@if(Session::has('message'))
            <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
            </div>
@endif

Reserva #: {{$reservation->confirmation_number}}.<br>
La reserva solicita {{$reservation->vehicle_quantity}} choferes.</p>

@if($reservation->vehicle_quantity > 1)

    <div class="mt-2">
    <p>Choferes actualmente asignados:</p>
    <ul>
    @foreach($reservation->driver as $current_driver)
    <li>Nombre: {{$current_driver->first_name }}.</li>
    <li>Apellido: {{$current_driver->last_name }}.</li>
    <li>Licencia de conducir: #{{$current_driver->car_license }}.</li>
    <hr>
    @endforeach
    </ul>
    </div>

    <div class="my-2">
    <p>Choferes disponibles:</p>
    </div>
    <form action="{{route('reservation.switchDriver',['id'=>$reservation->id])}}" method="post">
    @csrf
    @method('PUT')
    @foreach($available_drivers as $key => $ad)
    
      <div class="form-check">
      <input class="form-check-input" type="checkbox" name="driver[]" id="{{$ad->id}}" value="{{$ad->id}}"
      @if(is_array(old('driver')) && in_array($ad->id, old('driver'))) checked @endif
      @if( !old('driver') && in_array($ad->id, $selected) ) checked @endif
      >
      <label class="form-check-label" for="{{$ad->id}}">
      {{ $ad->first_name.' '.$ad->last_name.' '.$ad->license}}
      </div>
    @endforeach
    @if($errors->has('driver'))
      <div class="alert alert-danger"><p class="danger">{{ $errors->first('driver') }}</p></div>
    @endif
    <button class="btn">Continuar viaje</button>
    </form>
@else
    <div class="my-1">
    <p>Chofer actualmente asignado:</p>
    <ul>
        <li>Nombre: {{$reservation->driver[0]->first_name }}.</li>
        <li>Apellido: {{$reservation->driver[0]->last_name }}.</li>
        <li>Licencia de conducir: #{{$reservation->driver[0]->car_license }}.</li>
    </ul>
    </div>
    <div class="mb-1">
    <p>Choferes disponibles:</p>
    </div>
    <form action="{{route('reservation.switchDriver',['id'=>$reservation->id])}}" method="post">
    @csrf
    @method('PUT')
    @foreach($available_drivers as $ad)
        @if($ad->id == $reservation->driver[0]->id)
            @continue
        @endif
    <div class="form-check">
      <input class="form-check-input" type="radio" name="driver" id="{{$ad->id}}" value="{{$ad->id}}"
      {{ (old('driver') == $ad->id)? 'checked':''}}
      >
      <label class="form-check-label" for="{{$ad->id}}">
      {{ $ad->first_name.' '.$ad->last_name.' '.$ad->license }}
      </label>
    </div>
    @endforeach
    @if($errors->has('driver'))
      <div class="alert alert-danger">{{ $errors->first('driver') }}</div>
    @endif
    <button class="btn">Continuar viaje</button>
    </form>
@endif


</div>
@endsection