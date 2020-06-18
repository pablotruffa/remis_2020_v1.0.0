@extends('layout.main')
@section('title','Asignación chofer por reserva')

@push('styles')
    <link href="{{ url('css/driverAssign.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline my-2">Asignación chofer por reserva</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif
<div class="mb-1">
<p>Reserva #: {{$reservation->confirmation_number}}</p>
@if($reservation->vehicle_quantity > 1)
<p>La reserva solicita {{$reservation->vehicle_quantity}} choferes.</p>
</div>
<form action="{{route('reservation.startReservation',['id'=>$reservation->id])}}" method="post">
    @csrf
    @method('PUT')
    @foreach($available_drivers as $key => $ad)
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="driver[]" id="{{$ad->id}}" value="{{$ad->id}}"
      @if(is_array(old('driver')) && in_array($ad->id, old('driver'))) checked @endif
      >
      <label class="form-check-label" for="{{$ad->id}}">
      {{ $ad->first_name.' '.$ad->last_name.' '.$ad->license}}
    </div>
    @endforeach
    @if($errors->has('driver'))
      <div class="alert alert-danger"><p class="danger">{{ $errors->first('driver') }}</p></div>
    @endif
    <button>Iniciar viaje</button>
    </form>
@else
    <form action="{{route('reservation.startReservation',['id'=>$reservation->id])}}" method="post">
    @csrf
    @method('PUT')
    @foreach($available_drivers as $ad)
    <div class="form-check mb-2">
      <input class="form-check-input" type="radio" name="driver" id="{{$ad->id}}" value="{{$ad->id}}"
      {{ (old('driver') == $ad->id)? 'checked':''}}
      >
      <label class="form-check-label" for="{{$ad->id}}">
      {{ $ad->first_name.' '.$ad->last_name.' '.$ad->license }}
      </label>
    </div>
    @endforeach
    @if($errors->has('driver'))
      <div class="alert alert-danger"><p class="danger">{{ $errors->first('driver') }}</p></div>
    @endif
    <div><button class="btn">Iniciar viaje</button></div>
    </form>
@endif
</div>


@endsection