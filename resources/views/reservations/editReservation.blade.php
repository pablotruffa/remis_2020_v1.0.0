@extends('layout.main')
@section('title','Editar reserva')

@push('styles')
<link href="{{ url('css/reservation.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1>Editando la  reserva #{{ $reservation->confirmation_number }}</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif
<section>
<form action="{{ route('reservation.edit', ['id'=> $reservation->id])}}" method="post">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="client">Cliente</label>
    <select class="form-control" id="client" name="id_client">
      @foreach($clients as $client)
      <option value="{{ $client->id }}" 
            {{ $reservation->client[0]->id == $client->id ? 'selected' : '' }} 
            {{ old('id_client') == $client->id ? 'selected' : '' }}
            
            >{{ $client->first_name." ". $client->last_name }}</option>
      @endforeach
    </select>
        @if($errors->has('id_client'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('id_client') }}</p></div>
        @endif
  </div>
  <div class="form-group">
    <label for="travel_date">Fecha</label>
    <input type="date" class="form-control" id="travel_date" name="travel_date" value="{{ old('travel_date') ?? $reservation->travel_date }}">
            @if($errors->has('travel_date'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('travel_date') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="travel_time">Horario</label>
    <input type="time" class="form-control" id="travel_time" name="travel_time" value="{{ old('travel_time') ?? date('H:i', strtotime($reservation->travel_time)) }}">
            @if($errors->has('travel_time'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('travel_time') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="origin">Origen</label>
    <input type="text" class="form-control" id="origin" name="origin" value="{{ old('origin') ?? $reservation->origin}}">
            @if($errors->has('origin'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('origin') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="destiny">Destino</label>
    <input type="text" class="form-control" id="destiny" name="destiny" value="{{ old('destiny') ?? $reservation->destiny }}">
            @if($errors->has('destiny'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('destiny') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="vehicle_quantity">Cantidad de vehículos</label>
    <input type="number" class="form-control" id="vehicle_quantity" name="vehicle_quantity" value="{{ old('vehicle_quantity') ?? $reservation->vehicle_quantity}}">
            @if($errors->has('vehicle_quantity'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('vehicle_quantity') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="price">Importe a cobrar por vehículo:</label>
    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') ?? $reservation->price}}">
            @if($errors->has('price'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('price') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="commission_percentage">Porcentaje de comisión a base:</label>
    <input type="number" step="0.01" class="form-control" id="commission_percentage" name="commission_percentage" value="{{ old('commission_percentage') ?? $reservation->commission_percentage }}">
            @if($errors->has('commission_percentage'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('commission_percentage') }}</p></div>
            @endif
  </div>
  <button type="submit" class="btn btn-primary">Editar reserva</button>
</form>
</div>
@endsection