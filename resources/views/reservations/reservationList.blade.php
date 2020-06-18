@extends('layout.main')
@section('title','Listado de reservas')
@push('styles')
    <link href="{{ url('css/reservationList.css') }}" rel="stylesheet">
@endpush

@section('main')
<section class="main-content">
<h1 class="underline mt-2">{{$h1}}</h1>
@if(Session::has('message'))
            <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
            </div>
@endif

<div class="table-responsive">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#Confirmación</th>
      <th scope="col">Fecha</th>
      <th scope="col">Horario</th>
      <th scope="col">Origen</th>
      <th scope="col">Destino</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($reservations as $reservation)
    <tr>
      <td><a href="{{ route('reservation.info',['id'=>$reservation->id ]) }}">{{ $reservation->confirmation_number }}</a></td>
      <td>{{ $reservation->travel_date}}</td>
      <td>{{ $reservation->travel_time}}hs</td> 
      <td>{{ $reservation->origin}}</td> 
      <td>{{ $reservation->destiny}}</td> 
      <td>{{ $reservation->status->status }}</td>
      <td>
      @switch($reservation->reservation_status)
        @case(1)
          <a class="table-btn" href="{{route('reservation.formAssignDriver',['id'=>$reservation->id])}}" class="btn btn-secondary">Iniciar</a>
        @break
        @case(2)
         <a class="table-btn" href="{{route('reservation.formSwitchDriver',['id'=>$reservation->id])}}" class="btn btn-secondary">Cambiar chofer</a>
         @if($reservation->travel_date == date('Y-m-d',time()))
            <form style="display:inline" action="{{route('reservation.rollbackToStart',['id'=>$reservation->id])}}" method="post">
            @csrf
            @method('PUT')
            <button class="table-btn">Cancelar inicio</button>
            </form>
         @endif
         <form style="display:inline" action="{{route('reservation.endReservation',['id'=>$reservation->id])}}" method="post">
         @csrf
         @method('PUT')
         <button class="table-btn">Finalizar</button>
         </form>
        @break

        @case(4)
        @case(5)
          - Sin acciones -
        @break
      @endswitch
      </td>
    </tr>
   @endforeach
  </tbody>
</table>
</div>
</section>

@endsection

