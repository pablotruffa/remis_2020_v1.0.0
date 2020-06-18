@extends('layout.main')
@section('title','Viajes')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Mis viajes</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif
<div class="mb-5">
<form action="{{route('trips.date')}}" method="get">
<div class="form-row">
    <div class="form-group col-md-6">
      <label for="from">Desde</label>
      <input type="date" class="form-control" id="from" name="from" value="{{ old('from') }}" max="{{date('Y-m-d',time())}}" required>
    </div>
    <div class="form-group col-md-6">
      <label for="to">Hasta</label>
      <input type="date" class="form-control" id="to" name="to" value="{{  old('to')}}" max="{{date('Y-m-d',time())}}" required>
    </div>
</div>
<div><button class="btn btn-remis-dark btn-block">Buscar</button></div>
</form>
</div>
@if(count($balance->getReservations()) != 0)
   
<p>Resultados entre {{date('d-m-y',strtotime($from))}} / {{date('d-m-y',strtotime($to))}}</p>
<div class="table-responsive">
<table class="table">
  <thead >
    <tr>
      <th scope="col"># Reserva</th>
      <th scope="col">Fecha</th>
      <th scope="col">Origen</th>
      <th scope="col">Destino</th>
      <th scope="col">Precio</th>
      <th scope="col">Vehículos</th>
      <th scope="col">Comisión a Base</th>
      <th scope="col">Subtotal</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>
<?php $partial = 0;?>
@foreach($balance->getReservations() as $reservation)
<tr>
    <td>{{$reservation->confirmation_number}}</td>
    <td>{{$reservation->travel_date}}</td>
    <td>{{$reservation->origin}}</td>
    <td>{{$reservation->destiny}}</td>
    <td>{{$reservation->price}}</td>
    <td>{{$reservation->vehicle_quantity}}</td>
    <td>% {{$reservation->commission_percentage}}</td>
    <td>{{$reservation->getDriverIncome()}}</td>
    <?php $total = $partial + $reservation->getDriverIncome() ;?>
    <td>{{$total}}</td>
    <?php $partial = $total;?>
    
</tr>
@endforeach
</tbody>
</table>
</div>
<div>
    <form action="{{route('pdfTrips')}}" method="post">
        @csrf
        <input type="hidden" name="from" value="{{date('Y-m-d',strtotime($from))}}">
        <input type="hidden" name="to" value="{{date('Y-m-d',strtotime($to))}}">
        <button class="btn btn-info">Descargar Informe</button>
    </form>
</div>
@else
<p>No se encuentran registros de viajes</p>
@endif
</div>
@endsection
