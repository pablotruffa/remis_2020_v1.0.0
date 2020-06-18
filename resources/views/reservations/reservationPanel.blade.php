@extends('layout.main')
@push('styles')
    <link href="{{ url('css/reservationPanel.css') }}" rel="stylesheet">
@endpush
@section('title','Panel de reservas')

@section('main')
<div class="main-content">
<h1 class="underline mt-2">Reservas {{date('d-m-Y',time())}}</h1>
@if(Session::has('message'))
            <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
            </div>
@endif
</div>
<section id="panel" class="main-content">
  <div>
  <form action="{{route('reservation.date')}}" method="post">
      @csrf
      @method('GET')
      <div>
        <label for="search">Reservas por fecha:</label>
        <input class="my-1"  type="date" placeholder="Fecha" aria-label="Buscar" name="date" id="search">
        <button type="submit">Buscar </button>
      </div>
    </form>
  <form action="{{route('reservation.search')}}" method="post">
      @csrf
      <div>
        <label for="search">Reservas por # confirmación:</label>
        <input  class="my-1" type="text" placeholder="Confirmación" aria-label="Buscar" name="confirmation_number" id="search">
        <button type="submit">Buscar </button>
      </div>
    </form>
  </div>
  <div>
    <ul>
      <li><a href="{{route('reservations.confirmed')}}" class="btn"> <span>Reservas Confirmadas</span><span>{{count($reservations['confirmed'])}}</span></a></li>
      <li><a href="{{route('reservations.initiated')}}" class="btn"> <span>Reservas Iniciadas</span><span>{{count($reservations['initiated'])}}</span></a></li>
      <li><a href="{{route('reservations.postponed')}}" class="btn"> <span>Reservas Postergadas</span><span>{{count($reservations['postponed'])}}</span></a></li>
      <li><a href="{{route('reservations.cancelled')}}" class="btn"> <span>Reservas Canceladas</span><span>{{count($reservations['cancelled'])}}</span></a></li>
      <li><a href="{{route('reservations.completed')}}" class="btn"> <span>Reservas Concretadas</span><span>{{count($reservations['completed'])}}</span></a></li>
    </ul>
  </div>
</section>
<div class="my-2" >
<a href="{{route('reservation.formNew')}}" class="btn" id="new-reservation">Nueva reserva</a>
</div>
@endsection

